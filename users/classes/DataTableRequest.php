<?php
/**
 * DataTableRequest - Secure handler for DataTables server-side processing
 *
 * Provides validation for ORDER BY, LIMIT, and OFFSET parameters to prevent
 * SQL injection in server-side DataTables implementations.
 */
class DataTableRequest
{
    private DB $db;
    private array $columnMap = [];
    private array $tableColumns = [];
    private int $maxLength = 1000;
    private int $defaultLength = 25;

    public function __construct(?DB $db = null)
    {
        $this->db = $db ?? DB::getInstance();
    }

    /**
     * Set the column mapping from DataTables column indices to SQL column expressions
     *
     * @param array $columns Associative array: [index => 'sql_column_expression'] or sequential array
     *                       Use null for non-sortable columns
     * @return self
     */
    public function setColumns(array $columns): self
    {
        $this->columnMap = $columns;
        return $this;
    }

    /**
     * Dynamically load valid columns from one or more database tables
     * This provides an additional layer of validation beyond the column map
     *
     * @param string|array $tables Table name(s) to load columns from
     * @return self
     */
    public function loadTableColumns($tables): self
    {
        if (!is_array($tables)) {
            $tables = [$tables];
        }

        foreach ($tables as $table) {
            $result = $this->db->query("SHOW COLUMNS FROM `" . preg_replace('/[^a-zA-Z0-9_]/', '', $table) . "`");
            if (!$this->db->error()) {
                foreach ($result->results() as $col) {
                    $this->tableColumns[$table . '.' . $col->Field] = true;
                    $this->tableColumns[$col->Field] = true;
                }
            }
        }

        return $this;
    }

    /**
     * Set maximum allowed length for LIMIT clause
     *
     * @param int $max Maximum rows per page
     * @return self
     */
    public function setMaxLength(int $max): self
    {
        $this->maxLength = max(1, $max);
        return $this;
    }

    /**
     * Set default length when none provided
     *
     * @param int $default Default rows per page
     * @return self
     */
    public function setDefaultLength(int $default): self
    {
        $this->defaultLength = max(1, $default);
        return $this;
    }

    /**
     * Get validated ORDER BY clause
     *
     * @param string $defaultColumn Default column for sorting (must be in column map)
     * @param string $defaultDir Default direction ('ASC' or 'DESC')
     * @return string SQL ORDER BY clause (e.g., "ORDER BY column ASC") or empty string
     */
    public function getOrderBy(string $defaultColumn = '', string $defaultDir = 'ASC'): string
    {
        $column = null;
        $direction = $this->validateDirection($defaultDir);

        if (isset($_GET['order'][0]['column'])) {
            $colIndex = $this->sanitizeInt($_GET['order'][0]['column']);

            if ($colIndex !== null && array_key_exists($colIndex, $this->columnMap)) {
                $mappedColumn = $this->columnMap[$colIndex];

                if ($mappedColumn !== null && $this->isValidColumnExpression($mappedColumn)) {
                    $column = $mappedColumn;
                }
            }

            if (isset($_GET['order'][0]['dir'])) {
                $direction = $this->validateDirection($_GET['order'][0]['dir']);
            }
        }

        if ($column === null && $defaultColumn !== '') {
            if ($this->isValidColumnExpression($defaultColumn)) {
                $column = $defaultColumn;
            }
        }

        if ($column === null) {
            return '';
        }

        return "ORDER BY {$column} {$direction}";
    }

    /**
     * Get validated LIMIT clause
     *
     * @return string SQL LIMIT clause (e.g., "LIMIT 0, 25") or empty string for no limit
     */
    public function getLimit(): string
    {
        if (!isset($_GET['start']) && !isset($_GET['length'])) {
            return '';
        }

        // Check for "show all" request (-1)
        if (isset($_GET['length']) && $_GET['length'] == -1) {
            return '';
        }

        $start = $this->sanitizeInt($_GET['start'] ?? 0);
        $length = $this->sanitizeInt($_GET['length'] ?? $this->defaultLength);

        // Ensure non-negative start
        $start = max(0, $start ?? 0);

        // Ensure length is within bounds
        $length = max(1, min($this->maxLength, $length ?? $this->defaultLength));

        return "LIMIT {$start}, {$length}";
    }

    /**
     * Get validated draw parameter for DataTables
     *
     * @return int The draw counter
     */
    public function getDraw(): int
    {
        return $this->sanitizeInt($_GET['draw'] ?? 0) ?? 0;
    }

    /**
     * Validate sort direction
     *
     * @param mixed $dir Direction input
     * @return string 'ASC' or 'DESC'
     */
    private function validateDirection($dir): string
    {
        if (is_string($dir) && strtolower(trim($dir)) === 'desc') {
            return 'DESC';
        }
        return 'ASC';
    }

    /**
     * Sanitize and validate integer input
     * Only accepts integers or strings containing digits (optionally with leading minus for -1)
     *
     * @param mixed $value Input value
     * @return int|null Integer value or null if invalid
     */
    private function sanitizeInt($value): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }

        // Handle Input::sanitize'd values or raw values
        $cleaned = is_string($value) ? trim($value) : $value;

        // If already an int, return it
        if (is_int($cleaned)) {
            return $cleaned;
        }

        // Must be a string of digits, optionally with leading minus
        if (!is_string($cleaned) || !preg_match('/^-?\d+$/', $cleaned)) {
            return null;
        }

        return (int)$cleaned;
    }

    /**
     * Validate that a column expression is safe
     * Checks against loaded table columns if available, otherwise validates format
     *
     * @param string $expression Column expression (e.g., 'u.id', 'CONCAT(u.fname, " ", u.lname)')
     * @return bool True if expression appears safe
     */
    private function isValidColumnExpression(string $expression): bool
    {
        // Empty expressions are invalid
        if (trim($expression) === '') {
            return false;
        }

        // Check for obviously dangerous patterns
        $dangerous = [
            '/;\s*/',           // Statement terminator
            '/--/',             // SQL comment
            '/\/\*/',           // Block comment start
            '/\*\//',           // Block comment end
            '/\bUNION\b/i',     // UNION injection
            '/\bSELECT\b/i',    // Subquery injection
            '/\bINSERT\b/i',    // INSERT injection
            '/\bUPDATE\b/i',    // UPDATE injection
            '/\bDELETE\b/i',    // DELETE injection
            '/\bDROP\b/i',      // DROP injection
            '/\bEXEC\b/i',      // EXEC injection
            '/\bSLEEP\s*\(/i',  // Time-based injection
            '/\bBENCHMARK\s*\(/i', // Time-based injection
        ];

        foreach ($dangerous as $pattern) {
            if (preg_match($pattern, $expression)) {
                return false;
            }
        }

        // For simple column references (with optional table alias), validate against known columns
        if (preg_match('/^([a-zA-Z_][a-zA-Z0-9_]*\.)?([a-zA-Z_][a-zA-Z0-9_]*)$/', $expression, $matches)) {
            $colName = $matches[2];

            // If we have loaded table columns, verify the column exists
            if (!empty($this->tableColumns)) {
                // Check if column name exists in any loaded table
                if (!isset($this->tableColumns[$colName]) && !isset($this->tableColumns[$expression])) {
                    return false;
                }
            }

            return true;
        }

        // Allow common SQL functions used in ORDER BY (aggregate, string, date)
        $allowedFunctions = [
            'CONCAT', 'COALESCE', 'IFNULL', 'NULLIF',
            'LOWER', 'UPPER', 'TRIM', 'LENGTH',
            'DATE', 'YEAR', 'MONTH', 'DAY',
            'COUNT', 'SUM', 'AVG', 'MIN', 'MAX',
            'GROUP_CONCAT'
        ];

        // Check if expression starts with an allowed function
        foreach ($allowedFunctions as $func) {
            if (preg_match('/^' . $func . '\s*\(/i', $expression)) {
                // Basic validation that parentheses are balanced
                if (substr_count($expression, '(') === substr_count($expression, ')')) {
                    return true;
                }
            }
        }

        // Expression doesn't match any safe pattern
        return false;
    }
}
