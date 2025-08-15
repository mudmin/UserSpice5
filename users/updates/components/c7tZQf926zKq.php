<?php

//Sets disable2fa to private=1 instead of 2 (former coding error)
//Release Version Unknown
//Release Date Unknown
//Rewrote 2019-03-01 BA

$countE=0;

$tables = ['fingerprint_assets','Fingerprint_Assets','fingerprints','Fingerprints','us_fingerprints','us_fingerprint_assets'];
foreach($tables as $table) {
  $db->query("DROP TABLE $table");
  if(!$db->error()) {
    logger(1,"System Updates","Dropped table ".$table);
  }
  else {
    logger(1,"System Updates","Alert only: Failure dropping ".$table." Error: ".$db->errorString());
  }
}

$db->query("CREATE TABLE us_fingerprints (
  kFingerprintID int(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  fkUserID int(11) NOT NULL,
  Fingerprint varchar(32) NOT NULL,
  Fingerprint_Expiry datetime NOT NULL,
  Fingerprint_Added timestamp NOT NULL
)");
if(!$db->error()) {
  logger(1,"System Updates","Created table us_fingerprints");
} else {
  $error=$db->errorString();
  $countE++;
  logger(1,"System Updates","Failed to create table us_fingerprints, Error: ".$error);
  $errors[] = "Failed to create table us_fingerprints, Error: ".$error;
}

$db->query("CREATE TABLE us_fingerprint_assets (
  kFingerprintAssetID int(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  fkFingerprintID int(11) NOT NULL,
  IP_Address varchar(255) NOT NULL,
  User_Browser varchar(255) NOT NULL,
  User_OS varchar(255) NOT NULL
)");
if(!$db->error()) {
  logger(1,"System Updates","Created table us_fingerprint_assets");
} else {
  $error=$db->errorString();
  $countE++;
  logger(1,"System Updates","Failed to create table us_fingerprint_assets, Error: ".$error);
  $errors[] = "Failed to create table us_fingerprint_assets, Error: ".$error;
}

if($countE==0) {
  $db->insert('updates',['migration'=>$update]);
  if(!$db->error()) {
    if($db->count()>0) {
      logger(1,"System Updates","Update $update successfully deployed.");
      $successes[] = "Update $update successfully deployed.";
    } else {
      logger(1,"System Updates","Update $update unable to be marked complete, query was successful but no database entry was made.");
      $errors[] = "Update ".$update." unable to be marked complete, query was successful but no database entry was made.";
    }
  } else {
    $error=$db->errorString();
    logger(1,"System Updates","Update $update unable to be marked complete, Error: ".$error);
    $errors[] = "Update $update unable to be marked complete, Error: ".$error;
  }
} else {
  logger(1,"System Updates","Update $update unable to be marked complete");
  $errors[] = "Update $update unable to be marked complete";
}
