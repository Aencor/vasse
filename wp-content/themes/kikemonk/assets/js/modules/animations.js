import gsap from "gsap";
import Flip from "gsap/Flip";
import { ScrambleTextPlugin } from "gsap/ScrambleTextPlugin";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { ScrollToPlugin } from "gsap/ScrollToPlugin";
import { SplitText } from "gsap/SplitText";
import TextPlugin from "gsap/TextPlugin";

// Registrar plugins de GSAP
gsap.registerPlugin(Flip, ScrollTrigger, ScrambleTextPlugin, SplitText, ScrollToPlugin, TextPlugin);

export default {
  init() {
    // Only run animations if their containers exist
    if (document.querySelector('.coming-soon-screen')) {
      this.comingSoonAnimation();
    }

    if (document.querySelector('.hero-logo')) {
      this.heroAnimations();
    }

    if (document.querySelector('.js-scroll-animation')) {
      this.scrollAnimations();
    }

    // Inicializar animaciones para el componente de presentación
    if (document.querySelector('.presentation-item')) {
      this.presentationAnimations();
    }
  },

  heroAnimations() {
    // Set initial states
    gsap.set('.hero-logo', {
      autoAlpha: 0,
      y: 20
    });

    gsap.set('.typewriter-text', {
      autoAlpha: 0
    });

    // Create the main timeline
    const heroTL = gsap.timeline();

    // Logo fade-in animation
    heroTL.to('.hero-logo', {
      autoAlpha: 1,
      y: 0,
      duration: 1,
      ease: 'power3.out'
    });
    // Typewriter effect for text
    heroTL.to('.typewriter-text', {
      autoAlpha: 1,
      duration: 0.5,
      onStart: function () {
        const text = document.querySelector('.typewriter-text');
        if (!text) return;

        const content = text.textContent;
        text.textContent = ''; // Clear the text

        // Split into characters (mejor que en palabras para ola)
        const words = content.split(' ');

        words.forEach(word => {
          const span = document.createElement('span');
          span.textContent = word + ' '; // <-- ojo aquí, agregamos espacio
          text.appendChild(span);
        });

        const spans = text.querySelectorAll('span');

        // Animación de entrada
        gsap.from(spans, {
          opacity: 0,
          y: 40,
          duration: 1,
          ease: "power3.out",
          stagger: 0.15
        });

        // Ola infinita (palabra por palabra)
        let phase = { value: 0 };

        gsap.to(phase, {
          value: Math.PI * 2,
          duration: 2,
          repeat: -1,
          ease: "none",
          onUpdate: () => {
            spans.forEach((span, i) => {
              span.style.transform = `translateY(${Math.sin(i * 0.5 + phase.value) * 15}px)`;
            });
          }
        });

      }
    }, '-=0.5');

  },

  comingSoonAnimation() {
    // Crear una línea de tiempo para la animación
    const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });

    // Estado inicial
    gsap.set('.relative', { scale: 0.9, opacity: 0 });
    gsap.set('h1, h4', { opacity: 0, y: 20 });

    // Animación del logo con efecto de aparición
    tl.to('.relative', {
      scale: 1,
      opacity: 1,
      duration: 0.8,
      ease: 'back.out(1.7)'
    });

    // Animación del título con efecto scramble
    tl.to('h1', {
      opacity: 1,
      y: 0,
      duration: 0.6,
      scrambleText: {
        text: 'En Construcción',
        chars: 'upperAndLowerCase',
        revealDelay: 0.1,
        speed: 0.3
      }
    }, '-=0.3');

    // Animación del subtítulo
    tl.to('h4', {
      opacity: 1,
      y: 0,
      duration: 0.6,
      onComplete: function () {
        // Asegurarse de que el texto final sea el correcto
        gsap.set('h4', { text: '¡Estamos creando algo nuevo e impactante!' });
      }
    }, '-=0.4');
  },

  scrollAnimations() {
    // Verificar si hay elementos para animar
    const animateItems = document.querySelectorAll('.js-animate-item');
    if (!animateItems.length) return;

    // Configurar la animación para cada elemento
    animateItems.forEach((item) => {
      gsap.fromTo(item,
        { opacity: 0 },
        {
          opacity: 1,
          x: 0,
          duration: 0.8,
          ease: 'power2.out',
          scrollTrigger: {
            trigger: item.closest('.js-scroll-animation'),
            start: 'top 80%',
            toggleActions: 'play none none none',
            once: true
          },
          onComplete: () => {
            item.classList.add('is-visible');
          }
        }
      );
    });
  },

  presentationAnimations() {
    // Configurar animaciones para cada sección de presentación
    const presentationItems = document.querySelectorAll('.presentation-item');

    // Configuración inicial - ocultar todos los textos que tendrán efecto de escritura
    gsap.set('.presentation-item', { autoAlpha: 0, y: 30 });
    gsap.set('.typewriter-text', {
      opacity: 0,
      y: 20,
      display: 'inline-block'
    });

    // Crear un Intersection Observer para detectar cuando los elementos están en el viewport
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const item = entry.target;

          // Animación de entrada del contenedor
          gsap.to(item, {
            autoAlpha: 1,
            y: 0,
            duration: 0.8,
            ease: 'power2.out',
            onComplete: () => {
              // Aplicar efecto de escritura a todos los textos con la clase typewriter-text
              const textElements = item.querySelectorAll('.typewriter-text');
              textElements.forEach((el) => {
                this.applyTypewriterEffect(el);
              });
            }
          });

          // Dejar de observar este elemento
          observer.unobserve(item);
        }
      });
    }, {
      threshold: 0.2,
      rootMargin: '0px 0px -100px 0px'
    });

    // Observar cada elemento de presentación
    presentationItems.forEach((item) => {
      observer.observe(item);
    });
  },

  applyTypewriterEffect(element) {
    // Guardar el HTML original
    const originalHTML = element.innerHTML;

    // Limpiar el contenido
    element.innerHTML = '';

    // Procesar cada párrafo individualmente
    const paragraphs = originalHTML.split('</p>');

    paragraphs.forEach((para, paraIndex) => {
      if (!para.trim()) return;

      // Crear el párrafo
      const p = document.createElement('p');
      p.className = 'typewriter-paragraph';
      element.appendChild(p);

      // Limpiar y preparar el contenido
      let content = para.replace(/<[^>]*>/g, ' ').replace(/\s+/g, ' ').trim();

      // Dividir en palabras, incluyendo los signos de puntuación
      const words = content.match(/\S+[^\s.,;:!?]*[\s.,;:!?]*/g) || [];

      words.forEach((word, wordIndex) => {
        // Crear contenedor de palabra
        const wordSpan = document.createElement('span');
        wordSpan.className = 'word';
        wordSpan.textContent = word;
        wordSpan.style.opacity = '0';
        wordSpan.style.display = 'inline-block';
        wordSpan.style.whiteSpace = 'nowrap';

        // Agregar la palabra al párrafo
        p.appendChild(wordSpan);

        // Agregar un espacio después de cada palabra (excepto la última)
        if (wordIndex < words.length - 1) {
          const space = document.createTextNode(' ');
          p.appendChild(space);
        }

        // Animación de la palabra completa
        gsap.to(wordSpan, {
          opacity: 1,
          duration: 0.3,
          delay: wordIndex * 0.1, // Ajusta este valor para cambiar la velocidad
          ease: 'power2.out',
          onStart: () => {
            gsap.set(wordSpan, { display: 'inline-block' });
          }
        });
      });

      // Agregar espacio adicional entre párrafos
      if (paraIndex < paragraphs.length - 2) {
        const br1 = document.createElement('br');
        const br2 = document.createElement('br');
        element.appendChild(br1);
        element.appendChild(br2);
      }
    });
  },
};
