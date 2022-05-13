/*=========================================================================================
  File Name: router.js
  Description: Routes for vue-router. Lazy loading is enabled.
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

import Vue from "vue";
import Router from "vue-router";

Vue.use(Router);

const router = new Router({
    mode: "history",
    base: "/",
    scrollBehavior() {
        return { x: 0, y: 0 };
    },
    routes: [
        {
            path: "",
            redirect: "/pages/login"
        },

        {
            // =============================================================================
            // MAIN LAYOUT ROUTES
            // =============================================================================
            path: "",
            component: () => import("./layouts/main/Main.vue"),
            children: [
                // =============================================================================
                // Theme Routes
                // =============================================================================
                {
                    path: "/home",
                    name: "home",
                    component: () => import("./views/Home.vue")
                },
                {
                    path: "/Proveedores",
                    name: "Proveedores",
                    component: () =>
                        import("./views/Mantenedor/Proveedores.vue")
                },
                {
                    path: "/Laboratorio",
                    name: "Laboratorio",
                    component: () =>
                        import("./views/Mantenedor/Laboratorio.vue")
                },
                {
                    path: "/Anulacion",
                    name: "Anulacion",
                    component: () => import("./views/Mantenedor/Anulacion.vue")
                },
                {
                    path: "/Usuario",
                    name: "Usuario",
                    component: () => import("./views/Mantenedor/Usuario.vue")
                },
                {
                    path: "/UsuariosAuthRetiro",
                    name: "UsuariosAuthRetiro",
                    component: () =>
                        import("./views/Mantenedor/UsuariosAuthRetiro.vue")
                },
                {
                    path: "/Servicios",
                    name: "Servicios",
                    component: () => import("./views/Mantenedor/Servicios.vue")
                },
                {
                    path: "/AuthEstado",
                    name: "Auth. Estado",
                    component: () => import("./views/Mantenedor/AuthEstado.vue")
                },
                {
                    path: "/UsuarioLaboratorio",
                    name: "UsuarioLaboratorio",
                    component: () =>
                        import("./views/Mantenedor/UsuarioLaboratorio.vue")
                },
                {
                    path: "/ArticuloMedicamento",
                    name: "ArticuloMedicamento",
                    component: () =>
                        import("./views/Mantenedor/ArticuloMedicamento.vue")
                },
                {
                    path: "/ArticuloInsumoEconomato",
                    name: "ArticuloInsumoEconomato",
                    component: () =>
                        import("./views/Mantenedor/ArticuloInsumoEconomato.vue")
                }
            ]
        },
        // =============================================================================
        // FULL PAGE LAYOUTS
        // =============================================================================
        {
            path: "",
            component: () => import("@/layouts/full-page/FullPage.vue"),
            children: [
                // =============================================================================
                // PAGES
                // =============================================================================
                {
                    path: "/pages/login",
                    name: "page-login",
                    component: () => import("@/views/pages/Login.vue")
                },
                {
                    path: "/pages/error-404",
                    name: "page-error-404",
                    component: () => import("@/views/pages/Error404.vue")
                }
            ]
        },
        // Redirect to 404 page, if no match found
        {
            path: "*",
            redirect: "/pages/error-404"
        }
    ]
});

router.afterEach(() => {
    // Remove initial loading
    const appLoading = document.getElementById("loading-bg");
    if (appLoading) {
        appLoading.style.display = "none";
    }
});

export default router;
