// Cookie Consent Banner
function showCookieBanner() {
  if (document.cookie.includes('cookie_consent=true')) return;
  const banner = document.createElement('div');
  banner.id = 'cookie-consent-banner';
  banner.style.position = 'fixed';
  banner.style.bottom = '0';
  banner.style.left = '0';
  banner.style.width = '100%';
  banner.style.background = '#222';
  banner.style.color = '#fff';
  banner.style.padding = '1em';
  banner.style.zIndex = '9999';
  banner.innerHTML = `
    <div style="display:flex;justify-content:space-between;align-items:center;max-width:900px;margin:auto;">
      <span>
        We use cookies to improve your experience. See our <a href="/cookies" style="color:#ffd700;text-decoration:underline;">Cookies Policy</a>.
      </span>
      <button id="cookie-consent-accept" style="background:#ffd700;color:#222;padding:0.5em 1em;border:none;border-radius:4px;cursor:pointer;">Accept</button>
    </div>
  `;
  document.body.appendChild(banner);
  document.getElementById('cookie-consent-accept').onclick = function() {
    document.cookie = 'cookie_consent=true;path=/;max-age=31536000';
    banner.remove();
  };
}

export default showCookieBanner;
