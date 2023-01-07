document.addEventListener('DOMContentLoaded', function(){
  const drops = document.querySelectorAll('.us_menu .sub-toggle');
  for(let i = 0; i < drops.length; i++) {
    const drop = drops[i];
    drop.addEventListener('click', openDropdown);
  }
  const mobileControls = document.querySelectorAll('.us_menu_mobile_control');
  for(let i = 0; i < mobileControls.length; i++) {
    mobileControls[i].addEventListener('click', mobileControlClick);
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

function openDropdown(e) {
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
    // add backdrop if not exists (only works in admin dashboard)
    let bd = document.getElementById('us-menu-backdrop');
    if(!bd) {
      bd = document.createElement('div');
      bd.id = 'us-menu-backdrop';
      bd.className = 'us_menu_backdrop';
      bd.addEventListener('click', backdropClick);
      bd.style.zIndex = zIndex - 1;
      document.body.append(bd);
    }
  }
}

function backdropClick(evt) {
  const opens = document.querySelectorAll('.us_menu .us_sub-menu.show');
  for(let i = 0; i < opens.length; i++) {
    opens[i].classList.remove('show');
    // remove open
    var parent = opens[i].parentNode;
    parent.classList.remove('open');
  }
  evt.currentTarget.remove();
}

function mobileControlClick(evt) {
  evt.preventDefault();
  let menuId = `us_menu_${evt.currentTarget.dataset.target}`;
  //when dealing with dropdowns we need reformat the id to match the hamburger id
  menuId = menuId.replace('us_menu_#', 'us_');
  menuId = menuId.split("_", 4).join("_");
  const menu = document.getElementById(menuId);
  menu.classList.toggle('expanded');
}
