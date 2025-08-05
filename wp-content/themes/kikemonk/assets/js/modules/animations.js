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
    // Solo ejecutar comingSoonAnimation si existe el contenedor
    if (document.querySelector('.coming-soon-screen')) {
      this.comingSoonAnimation();
    }
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
  }
};
