document.addEventListener("DOMContentLoaded", (event) => {
  gsap.registerPlugin(Flip, ScrollTrigger, ScrollToPlugin, TextPlugin);

  // GSAP Sets y Animación
  document.querySelectorAll('.side-by-side-block').forEach(block => {
    var sideTL = gsap.timeline();
    var textContent = block.querySelector('.text-content');
    var imageContent = block.querySelector('.image-content');

    // GSAP Sets
    gsap.set(textContent, {
      y: -40, 
      autoAlpha: 0
    });

    gsap.set(imageContent, {
      y: 40, 
      autoAlpha: 0
    });

    // Animación Side by Side
    sideTL
      .to(textContent, {
        y: 0,
        autoAlpha: 1
      })
      .to(imageContent, {
        y: 0,
        autoAlpha: 1
      });

    // ScrollTrigger para cada bloque
    ScrollTrigger.create({
      trigger: block,
      start: 'top center',
      end: 'bottom',
      animation: sideTL
    });
  });
});
