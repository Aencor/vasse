// import Animations from '../modules/animations';
// import { slick } from 'slick-carousel';
// import 'slick-carousel/slick/slick.css';
// import 'slick-carousel/slick/slick-theme.css';

export default {
  init() {
    this.mobileMenu();
    this.handleHeaderScroll();
  },
  finalize() { },

  mobileMenu() {
    const menuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    if (menuButton && mobileMenu) {
      let isOpen = false;

      const toggleMenu = () => {
        isOpen = !isOpen;

        // Actualizar atributo aria-expanded
        menuButton.setAttribute('aria-expanded', isOpen);

        // Alternar la visibilidad del menú con transición
        if (isOpen) {
          mobileMenu.classList.remove('invisible', 'opacity-0');
          mobileMenu.classList.add('opacity-100', 'visible');
          document.body.style.overflow = 'hidden';
        } else {
          mobileMenu.classList.remove('opacity-100', 'visible');
          mobileMenu.classList.add('opacity-0');
          setTimeout(() => {
            if (!isOpen) mobileMenu.classList.add('invisible');
          }, 300); // Match this with the CSS transition duration
          document.body.style.overflow = '';
        }
      };

      // Configurar el evento de clic
      menuButton.addEventListener('click', toggleMenu);

      // Cerrar menú al hacer clic en un enlace
      const menuLinks = mobileMenu.querySelectorAll('a');
      menuLinks.forEach(link => {
        link.addEventListener('click', () => {
          isOpen = false;
          menuButton.setAttribute('aria-expanded', 'false');
          mobileMenu.classList.remove('opacity-100', 'visible');
          mobileMenu.classList.add('opacity-0');
          setTimeout(() => {
            mobileMenu.classList.add('invisible');
          }, 300);
          document.body.style.overflow = '';
        });
      });
    }
  },

  handleHeaderScroll() {
    const header = document.getElementById('masthead');
    const lightLogo = document.getElementById('light-logo');
    const darkLogo = document.getElementById('dark-logo');
    const logoContainer = document.querySelector('.logo a');

    if (!header || !lightLogo || !darkLogo) return;

    const handleScroll = () => {
      if (window.scrollY > 50) {
        header.classList.add('scrolled');
        // Mostrar logo oscuro
        lightLogo.classList.add('opacity-0');
        darkLogo.classList.remove('opacity-0');
      } else {
        header.classList.remove('scrolled');
        // Mostrar logo claro
        lightLogo.classList.remove('opacity-0');
        darkLogo.classList.add('opacity-0');
      }
    };

    // Ejecutar al cargar para verificar la posición inicial
    handleScroll();

    // Escuchar el evento de scroll con debounce para mejor rendimiento
    let ticking = false;
    window.addEventListener('scroll', () => {
      if (!ticking) {
        window.requestAnimationFrame(() => {
          handleScroll();
          ticking = false;
        });
        ticking = true;
      }
    });
  },
}