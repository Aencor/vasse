document.addEventListener("DOMContentLoaded", (event) => {
  gsap.registerPlugin(Flip, ScrollTrigger, ScrollToPlugin, TextPlugin);

  // GSAP Sets y Animación
  document.querySelectorAll('.logo-grid-block').forEach(block => {
    var gridTL = gsap.timeline();
    var logos = '.grid-item',
        title = '.grid-title',
        cta = '.grid-cta';

    // GSAP Sets
    gsap.set(logos, {
      y: -40, 
      autoAlpha: 0
    });

    gsap.set(title, {
      y: 40, 
      autoAlpha: 0
    });

    gsap.set(cta, { 
      autoAlpha: 0
    });

    // Animación Side by Side
    gridTL
      .to(title, {
        y: 0,
        autoAlpha: 1
      })
      .to(logos, {
        y: 0,
        autoAlpha: 1,
        stagger : 0.2
      })
      .to(cta, {
        autoAlpha: 1
      });

    // ScrollTrigger para cada bloque
    ScrollTrigger.create({
      trigger: block,
      start: 'top center',
      end: 'bottom',
      animation: gridTL
    });
  });
});
