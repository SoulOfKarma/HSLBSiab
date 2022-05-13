/*=========================================================================================
  File Name: sidebarItems.js
  Description: Sidebar Items list. Add / Remove menu items from here.
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

export default [
    {
        url: "/home",
        name: "Inicio",
        slug: "Inicio",
        icon: "HomeIcon"
    },

    {
        url: null,
        name: "Mantenedor",
        slug: "mantenedor",
        icon: "HomeIcon",
        submenu: [
            {
                url: "/Proveedores",
                name: "Proveedores",
                slug: "Proveedores",
                icon: "HomeIcon"
            },
            {
                url: "/Laboratorio",
                name: "Laboratorio",
                slug: "Laboratorio",
                icon: "HomeIcon"
            },
            {
                url: "/Anulacion",
                name: "Anulacion",
                slug: "Anulacion",
                icon: "HomeIcon"
            },
            {
                url: "/Usuario",
                name: "Usuario",
                slug: "Usuario",
                icon: "HomeIcon"
            },
            {
                url: "/UsuarioLaboratorio",
                name: "Usuario Laboratorio",
                slug: "UsuarioLaboratorio",
                icon: "HomeIcon"
            },
            {
                url: "/UsuariosAuthRetiro",
                name: "Autorizado Retiro",
                slug: "UsuariosAuthRetiro",
                icon: "HomeIcon"
            },
            {
                url: "/Servicios",
                name: "Servicios",
                slug: "Servicios",
                icon: "HomeIcon"
            },
            {
                url: "/AuthEstado",
                name: "Auth. Estado",
                slug: "AuthEstado",
                icon: "HomeIcon"
            },
            {
                url: "/ArticuloMedicamento",
                name: "Articulo Medicamento",
                slug: "ArticuloMedicamento",
                icon: "HomeIcon"
            },
            {
                url: "/ArticuloInsumoEconomato",
                name: "Articulo Insumo Economato",
                slug: "ArticuloInsumoEconomato",
                icon: "HomeIcon"
            }
        ]
    }
];
