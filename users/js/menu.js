document.addEventListener('DOMContentLoaded', function(){
  const drops = document.querySelectorAll('.us_menu .sub-toggle');
  for(let i = 0; i < drops.length; i++) {
    const drop = drops[i];
    drop.addEventListener('click', toggleDropdown);
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
        parentLi.firstChild.click();
      }

    }
  }
});

function closeSiblings(dropdown) {
  const parent = dropdown.parentNode; // menu UL
  if(!parent) return;
  let sibling = parent.firstChild; // children are DIV, LI, or TEXT
  while (sibling) {
    if (sibling != dropdown) {
      const dd = sibling.querySelector('.us_sub-menu.show');
      if (dd) {
        dd.classList.remove('show');
        dd.parentNode.classList.remove('open');
      }
    }
    sibling = sibling.nextSibling;
  }
}

function expandMenuIfMobile(menuId) {
  const screenWidth = window.innerWidth;
  if(screenWidth <= 992) {
    const menu = document.querySelector(`.us_menu[data-menu_id="${menuId}"]`);
    if(menu && !menu.classList.contains('expanded')) {
      menu.classList.add('expanded');
    }
  }
}

function toggleDropdown(e) {
  e.preventDefault();
  const parent = e.currentTarget.parentNode; // parent LI
  const sub = e.currentTarget.nextElementSibling; // submenu UL
  if(sub.classList.contains('show')) {
    sub.classList.remove('show');
    if (parent.classList.contains('open')) {
      parent.classList.remove('open');
    }
  }
  else {
    sub.classList.add('show');
    parent.classList.add('open');
    closeSiblings(parent); // this line fails on non-dashboard menu
    expandMenuIfMobile(parent.dataset.menu);
    const zIndex = parseInt(sub.style.zIndex, 10);
    let rect = sub.getBoundingClientRect();
    const windowWidth = window.innerWidth;
    // check to see if it goes off screen
    if((rect.x + rect.width) > windowWidth) {
      sub.style.left = 'unset';
      sub.style.right = '0';
    }
    //rect = sub.getBoundingClientRect();
    if(rect.x < 0) {
      sub.style.left = '0';
      sub.style.right = '0';
      sub.style.top = '100%';
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
      // if the menu is open and the click came from outside the menu
      document.removeEventListener('click', offClick);
      // find the open menu parent item and close it
      var open = e.target.closest(".dropdown.open");
      if (open) {
        // simulate the active item's parent menu link to be clicked, so it will close
        open.firstChild.click();
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
  menu.classList.toggle('expanded');
}
