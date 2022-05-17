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
                //Router de Mantenedor
                {
                    path: "/Mantenedor/Proveedores",
                    name: "/Mantenedor/Proveedores",
                    component: () =>
                        import("./views/Mantenedor/Proveedores.vue")
                },
                {
                    path: "/Mantenedor/Laboratorio",
                    name: "/Mantenedor/Laboratorio",
                    component: () =>
                        import("./views/Mantenedor/Laboratorio.vue")
                },
                {
                    path: "/Mantenedor/Anulacion",
                    name: "/Mantenedor/Anulacion",
                    component: () => import("./views/Mantenedor/Anulacion.vue")
                },
                {
                    path: "/Mantenedor/Usuario",
                    name: "/Mantenedor/Usuario",
                    component: () => import("./views/Mantenedor/Usuario.vue")
                },
                {
                    path: "/Mantenedor/UsuariosAuthRetiro",
                    name: "/Mantenedor/UsuariosAuthRetiro",
                    component: () =>
                        import("./views/Mantenedor/UsuariosAuthRetiro.vue")
                },
                {
                    path: "/Mantenedor/Servicios",
                    name: "/Mantenedor/Servicios",
                    component: () => import("./views/Mantenedor/Servicios.vue")
                },
                {
                    path: "/Mantenedor/AuthEstado",
                    name: "/Mantenedor/Auth. Estado",
                    component: () => import("./views/Mantenedor/AuthEstado.vue")
                },
                {
                    path: "/Mantenedor/UsuarioLaboratorio",
                    name: "/Mantenedor/UsuarioLaboratorio",
                    component: () =>
                        import("./views/Mantenedor/UsuarioLaboratorio.vue")
                },
                {
                    path: "/Mantenedor/ArticuloMedicamento",
                    name: "/Mantenedor/ArticuloMedicamento",
                    component: () =>
                        import("./views/Mantenedor/ArticuloMedicamento.vue")
                },
                {
                    path: "/Mantenedor/ArticuloInsumoEconomato",
                    name: "/Mantenedor/ArticuloInsumoEconomato",
                    component: () =>
                        import("./views/Mantenedor/ArticuloInsumoEconomato.vue")
                },
                {
                    path: "/Mantenedor/Bodega",
                    name: "/Mantenedor/Bodega",
                    component: () => import("./views/Mantenedor/Bodega.vue")
                },
                {
                    path: "/Mantenedor/Zona",
                    name: "/Mantenedor/Zona",
                    component: () => import("./views/Mantenedor/Zona.vue")
                },
                //Router de Recepcion
                {
                    path: "/Recepcion/Recepcion",
                    name: "/Recepcion/Recepcion",
                    component: () => import("./views/Recepcion/Recepcion.vue")
                },
                {
                    path: "/Recepcion/OrdenCompra",
                    name: "/Recepcion/OrdenCompra",
                    component: () => import("./views/Recepcion/OrdenCompra.vue")
                },
                //Router de Consumo Inmediato
                {
                    path: "/ConsumoInmediato/Recepcion",
                    name: "/ConsumoInmediato/Recepcion",
                    component: () =>
                        import("./views/ConsumoInmediato/Recepcion.vue")
                },
                {
                    path: "/ConsumoInmediato/ListaRecepcion",
                    name: "/ConsumoInmediato/ListaRecepcion",
                    component: () =>
                        import("./views/ConsumoInmediato/ListaRecepcion.vue")
                },
                //Router de Despacho
                {
                    path: "/Despacho/DespachoPEspeciales",
                    name: "/Despacho/DespachoPEspeciales",
                    component: () =>
                        import("./views/Despacho/DespachoPEspeciales.vue")
                },
                {
                    path: "/Despacho/SolicitudPedidos",
                    name: "/Despacho/SolicitudPedidos",
                    component: () =>
                        import("./views/Despacho/SolicitudPedidos.vue")
                },
                //Router de Despacho
                {
                    path: "/Reportes/SaldoXProducto",
                    name: "/Reportes/SaldoXProducto",
                    component: () =>
                        import("./views/Reportes/SaldoXProducto.vue")
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
