(function() {
  "use strict"; // Start of use strict

  var mainNav = document.querySelector('#mainNav');

  if (mainNav) {

    var navbarCollapse = mainNav.querySelector('.navbar-collapse');
    
    if (navbarCollapse) {

      var collapse = new bootstrap.Collapse(navbarCollapse, {
        toggle: false
      });
      
      var navbarItems = navbarCollapse.querySelectorAll('a');
      
      // Closes responsive menu when a scroll trigger link is clicked
      for (var item of navbarItems) {
        item.addEventListener('click', function (event) {
          collapse.hide();
        });
      }
    }

    // Collapse Navbar
    var collapseNavbar = function() {

      var scrollTop = (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop;

      if (scrollTop > 100) {
        mainNav.classList.add("navbar-shrink");
      } else {
        mainNav.classList.remove("navbar-shrink");
      }
    };
    // Collapse now if page is not at top
    collapseNavbar();
    // Collapse the navbar when page is scrolled
    document.addEventListener("scroll", collapseNavbar);
  }

  const openBtn = document.getElementById('open-cart-btn');
  const closeBtn = document.getElementById('close-cart');
  const cartPanel = document.getElementById('cart-panel');
  const overlay = document.getElementById('overlay');
  const cartHandle = document.getElementById('cart-handle');
  const cartItemsEl = document.getElementById('cart-items');
  const cartEmptyEl = document.getElementById('cart-empty');
  const totalEl = document.getElementById('cart-total');
  const checkoutBtn = document.getElementById('checkout');

  let cart = [];

  function formatCurrency(n){
    return '₱' + Number(n).toFixed(2);
  }

  function renderCart(){
    cartItemsEl.innerHTML = '';
    if(cart.length === 0){
      cartItemsEl.hidden = true;
      cartEmptyEl.style.display = 'block';
      checkoutBtn.disabled = true;
      totalEl.textContent = formatCurrency(0);
      return;
    }
    cartEmptyEl.style.display = 'none';
    cartItemsEl.hidden = false;

    cart.forEach((item, idx) => {
      const li = document.createElement('li');
      li.className = 'cart-item';
      li.innerHTML = `
        <div class="meta">
          <div style="font-weight:600">${item.name}</div>
          <div style="color:#777;font-size:13px">${formatCurrency(item.price)} x ${item.qty}</div>
        </div>
        <div class="controls">
          <button data-action="dec" data-idx="${idx}">−</button>
          <span style="padding:0 8px">${item.qty}</span>
          <button data-action="inc" data-idx="${idx}">+</button>
        </div>
      `;
      cartItemsEl.appendChild(li);
    });

    const total = cart.reduce((s,i)=> s + i.price * i.qty, 0);
    totalEl.textContent = formatCurrency(total);
    checkoutBtn.disabled = false;
  }

  function toggleCart(open){
    const isOpen = typeof open === 'boolean' ? open : cartPanel.classList.contains('closed');
    if(isOpen){
      cartPanel.classList.remove('closed');
      cartPanel.setAttribute('aria-hidden','false');
      openBtn.setAttribute('aria-expanded','true');
      cartHandle && cartHandle.setAttribute('aria-expanded','true');
      overlay.hidden = false;
    } else {
      cartPanel.classList.add('closed');
      cartPanel.setAttribute('aria-hidden','true');
      openBtn.setAttribute('aria-expanded','false');
      cartHandle && cartHandle.setAttribute('aria-expanded','false');
      overlay.hidden = true;
    }
  }

  // Wire up product add buttons
  document.querySelectorAll('.product .add').forEach(btn=>{
    btn.addEventListener('click', e=>{
      const card = btn.closest('.product');
      const id = card.dataset.id;
      const name = card.dataset.name;
      const price = Number(card.dataset.price) || 0;
      const existing = cart.find(i=> i.id === id);
      if(existing) existing.qty++;
      else cart.push({id,name,price,qty:1});
      renderCart();
      toggleCart(true); // open when item added
    });
  });

  // Cart inc/dec events
  cartItemsEl.addEventListener('click', e=>{
    const btn = e.target.closest('button');
    if(!btn) return;
    const idx = Number(btn.dataset.idx);
    const action = btn.dataset.action;
    if(action === 'inc') cart[idx].qty++;
    if(action === 'dec'){
      cart[idx].qty--;
      if(cart[idx].qty <= 0) cart.splice(idx,1);
    }
    renderCart();
  });

  // Toggle handlers
  openBtn.addEventListener('click', ()=> toggleCart(true));
  closeBtn.addEventListener('click', ()=> toggleCart(false));
  cartHandle && cartHandle.addEventListener('click', ()=> {
    const closed = cartPanel.classList.contains('closed');
    toggleCart(closed);
  });

  overlay.addEventListener('click', ()=> toggleCart(false));

  // Fulfillment tabs
  document.querySelectorAll('.fulfill-tab').forEach(t=>{
    t.addEventListener('click', ()=>{
      document.querySelectorAll('.fulfill-tab').forEach(x=>{
        x.classList.remove('active');
        x.setAttribute('aria-selected','false');
      });
      t.classList.add('active');
      t.setAttribute('aria-selected','true');
      // You can respond to mode change using t.dataset.mode
    });
  });

  // Checkout click
  checkoutBtn.addEventListener('click', ()=>{
    if(cart.length === 0) return;
    alert('Proceed to checkout with ' + cart.length + ' item(s).');
  });

  // initial render
  renderCart();
  // Start closed on mobile/desktop
  toggleCart(false);

})(); // End of use strict

