document.addEventListener('DOMContentLoaded', () => {
  const imgs = document.querySelectorAll('img[loading="lazy"]');

  if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver((entries, obs) => {
      entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        const img = entry.target;
        const ds = img.dataset.src;
        if (ds) img.src = ds;
        const dsset = img.dataset.srcset;
        if (dsset) img.srcset = dsset;
        const dsizes = img.dataset.sizes;
        if (dsizes) img.sizes = dsizes;
        obs.unobserve(img);
      });
    });
    imgs.forEach(img => observer.observe(img));
  } else {
    imgs.forEach(img => {
      img.src     = img.dataset.src     || img.src;
      img.srcset  = img.dataset.srcset  || img.srcset;
      img.sizes   = img.dataset.sizes   || img.sizes;
    });
  }
});
