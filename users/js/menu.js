document.addEventListener('DOMContentLoaded', function(){
  const drops = document.querySelectorAll('.us_menu .sub-toggle');
  for(let i = 0; i < drops.length; i++) {
    const drop = drops[i];
    drop.addEventListener('click', toggleDropdown);
    drop.addEventListener('keydown', toggleKeydown);
  }
  const mobileControls = document.querySelectorAll('.us_menu_mobile_control');
  for(let i = 0; i < mobileControls.length; i++) {
    mobileControls[i].addEventListener('click', mobileControlClick);
  }

  // get the active menu item (accordion only)
  var active = document.querySelector('.us_menu.accordion li.active');
  // find out if the active element is inside a submenu. If so, open the submenu on page load (accordion only)
  if (active) {
    var parent = active.closest('ul');
    if (parent.classList.contains("us_sub-menu")) {
      var parentLi = parent.closest('li.dropdown');
      if (parentLi) {
        // simulate the active item's parent menu link to be clicked, so it will open
        parentLi.firstElementChild.click();
      }

    }
  }
});

function closeSiblings(dropdown) {
  const parent = dropdown.parentNode; // menu UL
  if(!parent) return;
  let sibling = parent.firstElementChild; // skip text nodes, only get elements
  while (sibling) {
    if (sibling != dropdown) {
      const dd = sibling.querySelector('.us_sub-menu.show');
      if (dd) {
        dd.classList.remove('show');
        dd.parentNode.classList.remove('open');
        syncExpanded(dd.previousElementSibling, false);
      }
    }
    sibling = sibling.nextElementSibling;
  }
}

function syncExpanded(toggle, expanded) {
  if (toggle) {
    toggle.setAttribute('aria-expanded', expanded ? 'true' : 'false');
  }
}

// Dropdown toggles are <a role="button">: links only activate on Enter, so add
// Space like a real button, and Escape closes the open dropdown.
function toggleKeydown(e) {
  if (e.key === ' ' || e.key === 'Spacebar') {
    e.preventDefault();
    e.currentTarget.click();
  } else if (e.key === 'Escape' && e.currentTarget.getAttribute('aria-expanded') === 'true') {
    e.preventDefault();
    e.currentTarget.click();
  }
}

document.addEventListener('keydown', function(e) {
  if (e.key !== 'Escape' || e.defaultPrevented) return;
  const open = e.target.closest && e.target.closest('.us_menu .dropdown.open');
  if (!open || e.target === open.firstElementChild) return;
  const toggle = open.firstElementChild;
  toggle.click();
  toggle.focus();
});

function expandMenuIfMobile(menuId) {
  const screenWidth = window.innerWidth;
  if(screenWidth <= 992) {
    const menu = document.querySelector(`.us_menu[data-menu_id="${menuId}"]`);
    if(menu && !menu.classList.contains('expanded')) {
      menu.classList.add('expanded');
      syncExpanded(menu.querySelector('.us_menu_mobile_control'), true);
    }
  }
}

function toggleDropdown(e) {
  e.preventDefault();
  const parent = e.currentTarget.parentNode; // parent LI
  const sub = e.currentTarget.nextElementSibling; // submenu UL
  if(sub.classList.contains('show')) {
    sub.classList.remove('show');
    syncExpanded(e.currentTarget, false);
    if (parent.classList.contains('open')) {
      parent.classList.remove('open');
    }
  }
  else {
    sub.classList.add('show');
    syncExpanded(e.currentTarget, true);
    parent.classList.add('open');
    closeSiblings(parent); // this line fails on non-dashboard menu
    expandMenuIfMobile(parent.dataset.menu);
    // reset any previously applied inline positioning
    sub.style.left = '';
    sub.style.right = '';
    sub.style.top = '';

    let rect = sub.getBoundingClientRect();
    const windowWidth = window.innerWidth;
    const isDeepSub = sub.classList.contains('us_deep-sub-menu');

    if (isDeepSub) {
      // deep sub-menus default to left: 100% (right of parent)
      // if that overflows the right edge, flip to the left side
      if ((rect.x + rect.width) > windowWidth) {
        sub.style.left = 'unset';
        sub.style.right = '100%';
        rect = sub.getBoundingClientRect();
      }
      // if flipping left pushes it off the left edge, drop below instead
      if (rect.x < 0) {
        sub.style.left = '0';
        sub.style.right = 'unset';
        sub.style.top = '100%';
      }
    } else {
      // first-level sub-menu (drops below parent in horizontal)
      if ((rect.x + rect.width) > windowWidth) {
        sub.style.left = 'unset';
        sub.style.right = '0';
      }
      if (rect.x < 0) {
        sub.style.left = '0';
        sub.style.right = 'unset';
      }
    }
    // close menu if clicked outside it (top menu only)
    if (document.querySelector('.us_menu.horizontal')) {
      addOffClick(e);
    }
  }
}

// we only need this behaviour for the top menu, not sidebar or accordion
const addOffClick = (e) => {
  const offClick = (evt) => {
    if (e.target !== evt.target) {
      // don't close if the click was inside the open dropdown (e.g. nested sub-toggle)
      var open = e.target.closest(".dropdown.open");
      if (open && open.contains(evt.target)) {
        return;
      }
      // if the menu is open and the click came from outside the menu
      document.removeEventListener('click', offClick);
      if (open) {
        // simulate the active item's parent menu link to be clicked, so it will close
        open.firstElementChild.click();
      }
    }
  };
  // menu was closed, and is now open, so we add the listener for clicks outside the menu
  document.addEventListener('click', offClick);
};

function mobileControlClick(evt) {
  evt.preventDefault();
  let menuId = `us_menu_${evt.currentTarget.dataset.target}`;
  //when dealing with dropdowns we need reformat the id to match the hamburger id
  menuId = menuId.replace('us_menu_#', 'us_');
  menuId = menuId.split("_", 4).join("_");
  const menu = document.getElementById(menuId);
  const expanded = menu.classList.toggle('expanded');
  syncExpanded(evt.currentTarget, expanded);
}
