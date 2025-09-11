// import Animations from '../modules/animations';
// import { slick } from 'slick-carousel';
// import 'slick-carousel/slick/slick.css';
// import 'slick-carousel/slick/slick-theme.css';

export default {
  init() {
    this.mobileMenu();
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
}