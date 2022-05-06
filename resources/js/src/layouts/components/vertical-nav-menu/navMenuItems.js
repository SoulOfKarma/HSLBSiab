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
                url: "/UsuariosAuthRetiro",
                name: "Autorizado Retiro",
                slug: "UsuariosAuthRetiro",
                icon: "HomeIcon"
            }
        ]
    }
];
