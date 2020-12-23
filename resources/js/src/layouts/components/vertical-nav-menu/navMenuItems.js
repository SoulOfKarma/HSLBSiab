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
        name: "Material",
        slug: "entregadematerial",
        icon: "HomeIcon",
        submenu: [
            {
                url: "/materialNuevo",
                name: "Ingreso Material",
                slug: "IngresoMaterial",
                icon: "HomeIcon"
            },
            {
                url: "/stockMaterialIngresado",
                name: "Stock",
                slug: "Stock",
                icon: "HomeIcon"
            },
            {
                url: "/stockTotal",
                name: "Stock Total",
                slug: "Stock",
                icon: "HomeIcon"
            },
            {
                url: "/listadoSolicitudes",
                name: "Listado Solicitudes",
                slug: "listadosolicitudes",
                icon: "HomeIcon"
            }
        ]
    }
];
