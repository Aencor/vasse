// use a script tag or an external JS file
document.addEventListener("DOMContentLoaded", (event) => {
  gsap.registerPlugin(Flip, ScrollTrigger, ScrollToPlugin, TextPlugin)
  // Footer animation
  var headerTL = gsap.timeline(),
    block = '.hero-block',
    title = '.hero-title',
    content = '.h-content',
    cta = '.hero-cta',
    mask = '.circle-mask',
    image = '.hero-image';

  // GSAP Sets

  gsap.set(block, {
    autoAlpha: 0
  });

  gsap.set(title, {
    y: -40,
    autoAlpha: 0
  });

  gsap.set(content, {
    autoAlpha: 0
  });

  gsap.set(cta, {
    y: 40,
    autoAlpha: 0
  });

  gsap.set(mask, {
    autoAlpha: 0
  });

  gsap.set(image, {
    autoAlpha: 0,
    scale: 0
  });

  gsap.set('.hero-logo', {
    autoAlpha: 0,
    y: 20
  });

  gsap.set('.typewriter-text', {
    autoAlpha: 0
  });

  // Create the main timeline
  var heroTL = gsap.timeline();

  // Logo fade-in animation
  heroTL.to('.hero-logo', {
    autoAlpha: 1,
    y: 0,
    duration: 1,
    ease: 'power3.out'
  });

  alert('hola');
  // Typewriter effect for text
  heroTL.to('.typewriter-text', {
    autoAlpha: 1,
    duration: 0.5,
    onStart: function () {
      // Split text into words for typewriter effect
      const text = document.querySelector('.typewriter-text');
      if (text) {
        const content = text.textContent;
        text.textContent = ''; // Clear the text

        // Create a span for each character
        const chars = content.split('');
        chars.forEach((word, i) => {
          const span = document.createElement('span');
          span.textContent = word === ' ' ? '\u00A0' : word;
          span.style.opacity = '0';
          text.appendChild(span);

          // Animate each character with a slight delay
          gsap.to(span, {
            opacity: 1,
            duration: 0.05,
            delay: i * 0.03,
            ease: 'none'
          });
        });
      }
    }
  }, '-=0.5'); // Overlap with the logo animation slightly

  headerTL
    .to(block, {
      autoAlpha: 1
    })
    .to(mask, {
      delay: .5,
      autoAlpha: 1,
    })
    .to(title, {
      y: 0,
      autoAlpha: 1
    })
    .to(content, {
      autoAlpha: 1
    })
    .to(cta, {
      y: 0,
      autoAlpha: 1
    })
    .to(image, {
      scale: 1,
      autoAlpha: 1
    })
});