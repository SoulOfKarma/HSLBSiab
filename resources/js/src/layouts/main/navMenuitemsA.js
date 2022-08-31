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
                url: "/Mantenedor/ArticuloMedicamento",
                name: "Articulo Medicamento",
                slug: "/Mantenedor/ArticuloMedicamento",
                icon: "HomeIcon"
            },
            {
                url: "/Mantenedor/ArticuloEconomato",
                name: "Articulo Economato",
                slug: "/Mantenedor/ArticuloEconomato",
                icon: "HomeIcon"
            },
            {
                url: "/Mantenedor/ArticuloInsumo",
                name: "Articulo Insumo",
                slug: "/Mantenedor/ArticuloInsumo",
                icon: "HomeIcon"
            },
            {
                url: "/Mantenedor/StockMinMax",
                name: "Stock Insumo/Economato",
                slug: "/Mantenedor/StockMinMax",
                icon: "HomeIcon"
            },
            {
                url: "/Mantenedor/StockMinMaxMed",
                name: "Stock Medicamentos",
                slug: "/Mantenedor/StockMinMaxMed",
                icon: "HomeIcon"
            },
            {
                url: "/Mantenedor/SaldoInventario",
                name: "Saldo Inventario",
                slug: "/Mantenedor/SaldoInventario",
                icon: "HomeIcon"
            }
        ]
    },
    {
        url: null,
        name: "Recepcion",
        slug: "recepcion",
        icon: "HomeIcon",
        submenu: [
            {
                url: "/Recepcion/Recepcion",
                name: "Recepcion",
                slug: "/Recepcion/Recepcion",
                icon: "HomeIcon"
            },
            {
                url: "/Recepcion/ListadoRecepcionAbierta",
                name: "Rec. Abiertas",
                slug: "/Recepcion/ListadoRecepcionAbierta",
                icon: "HomeIcon"
            },
            {
                url: "/Recepcion/ListadoRecepcionCerrada",
                name: "Rec. Cerradas",
                slug: "/Recepcion/ListadoRecepcionCerrada",
                icon: "HomeIcon"
            },
            {
                url: "/Recepcion/ListadoRecepcionAnuladas",
                name: "Rec. Anuladas",
                slug: "/Recepcion/ListadoRecepcionAnuladas",
                icon: "HomeIcon"
            }
        ]
    },
    {
        url: null,
        name: "Despacho",
        slug: "despacho",
        icon: "HomeIcon",
        submenu: [
            {
                url: "/Despacho/SolicitudPedidos",
                name: "Solicitud Pedidos",
                slug: "/Despacho/SolicitudPedidos",
                icon: "HomeIcon"
            },
            {
                url: "/Despacho/ListadoDespachoAbierto",
                name: "Despachos Abiertos",
                slug: "/Despacho/ListadoDespachoAbierto",
                icon: "HomeIcon"
            },
            {
                url: "/Despacho/ListadoDespachosCerrados",
                name: "Despachos Cerrados",
                slug: "/Despacho/ListadoDespachosCerrados",
                icon: "HomeIcon"
            },
            {
                url: "/Despacho/ListadoDespachosAnulados",
                name: "Despachos Anulados",
                slug: "/Despacho/ListadoDespachosAnulados",
                icon: "HomeIcon"
            }
        ]
    },
    {
        url: null,
        name: "Reportes",
        slug: "reportes",
        icon: "HomeIcon",
        submenu: [
            {
                url: "/Reportes/Reportes",
                name: "Reportes",
                slug: "/Reportes/Reportes",
                icon: "HomeIcon"
            }
        ]
    },
    {
        url: null,
        name: "FirmaTest",
        slug: "FirmaTest",
        icon: "HomeIcon",
        submenu: [
            {
                url: "/Firma/FirmaTest",
                name: "FirmaTest",
                slug: "/Firma/FirmaTest",
                icon: "HomeIcon"
            }
        ]
    }
];
