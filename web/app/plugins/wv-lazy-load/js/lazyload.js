document.addEventListener('DOMContentLoaded', () => {
  const imgs = document.querySelectorAll('img[loading="lazy"]');

  if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver((entries, obs) => {
      entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        const img = entry.target;

        // Charger la vraie source
        const dataSrc = img.getAttribute('data-src');
        if (dataSrc) img.src = dataSrc;

        // Charger le vrai srcset
        const dataSrcset = img.getAttribute('data-srcset');
        if (dataSrcset) img.srcset = dataSrcset;

        // Charger la vraie taille
        const dataSizes = img.getAttribute('data-sizes');
        if (dataSizes) img.sizes = dataSizes;

        obs.unobserve(img);
      });
    });
    imgs.forEach(img => observer.observe(img));
  } else {
    // Fallback : charger immédiatement
    imgs.forEach(img => {
      img.src     = img.getAttribute('data-src')     || img.src;
      img.srcset  = img.getAttribute('data-srcset')  || img.srcset;
      img.sizes   = img.getAttribute('data-sizes')   || img.sizes;
    });
  }
});
