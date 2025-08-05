import Router from "./router";
import common from "./routes/common";
import animations from "./modules/animations";
import darkMode from "./modules/darkMode";

/**
 * Populate Router instance with DOM routes
 * @type {Router} routes - An instance of our router
 */
const routes = new Router({
  common,
});

$(function () {
  routes.loadEvents();
  darkMode.init();
  animations.init();
});
