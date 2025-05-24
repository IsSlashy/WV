document.addEventListener('DOMContentLoaded', () => {
  // 1) On ne prend que les vraies images lazy (avec data-src)
  const imgs = Array.from(document.querySelectorAll('img[loading="lazy"]'))
    .filter(img => img.dataset.src);

  if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver((entries, obs) => {
      entries.forEach(entry => {
        if (!entry.isIntersecting) return;

        const img = entry.target;
        const dataSrc = img.dataset.src;

        if (dataSrc) {
          console.log('🔥 Actif', dataSrc);
          img.src = dataSrc;
        }

        const dataSrcset = img.dataset.srcset;
        if (dataSrcset) img.srcset = dataSrcset;

        const dataSizes = img.dataset.sizes;
        if (dataSizes) img.sizes = dataSizes;

        obs.unobserve(img);
      });
    });

    imgs.forEach(img => observer.observe(img));
  } else {
    imgs.forEach(img => {
      img.src    = img.dataset.src    || img.src;
      img.srcset = img.dataset.srcset || img.srcset;
      img.sizes  = img.dataset.sizes  || img.sizes;
    });
  }
});
