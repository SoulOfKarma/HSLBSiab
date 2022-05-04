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
                url: null,
                name: "Ingreso Material",
                slug: "IngresoMaterial",
                icon: "HomeIcon"
            }
        ]
    }
];
