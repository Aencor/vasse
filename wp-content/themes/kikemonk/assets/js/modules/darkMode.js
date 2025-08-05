const darkMode = {
  init() {
    const darkModeToggle = document.getElementById('darkModeToggle');

    // Verificar si el botón de modo oscuro existe en la página
    if (!darkModeToggle) return;

    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const savedMode = localStorage.getItem('theme');

    // Función para actualizar las clases de modo oscuro
    const updateDarkModeClasses = (isDark) => {
      if (isDark) {
        document.documentElement.classList.add('dark');
      } else {
        document.documentElement.classList.remove('dark');
      }
    };

    // Aplicar modo inicial basado en preferencias guardadas o del sistema
    if (savedMode === 'dark' || (!savedMode && prefersDark)) {
      updateDarkModeClasses(true);
    } else {
      updateDarkModeClasses(false);
    }

    // Configurar el evento de clic para alternar modo oscuro
    darkModeToggle.addEventListener('click', () => {
      const isDark = document.documentElement.classList.contains('dark');
      updateDarkModeClasses(!isDark);
      localStorage.setItem('theme', isDark ? 'light' : 'dark');
    });

    // Escuchar cambios en las preferencias del sistema
    window.matchMedia('(prefers-color-scheme: dark)').addListener(e => {
      if (!localStorage.getItem('theme')) {
        updateDarkModeClasses(e.matches);
      }
    });
  }
};

export default darkMode;
