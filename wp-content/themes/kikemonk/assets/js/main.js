import Router from "./router";
import common from "./routes/common";

/**
 * Populate Router instance with DOM routes
 * @type {Router} routes - An instance of our router
 */
const routes = new Router({
  common,
});

$(function () {
  routes.loadEvents();
});
