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
                url: "/Mantenedor/Proveedores",
                name: "Proveedores",
                slug: "/Mantenedor/Proveedores",
                icon: "HomeIcon"
            },
            {
                url: "/Mantenedor/Laboratorio",
                name: "Laboratorio",
                slug: "/Mantenedor/Laboratorio",
                icon: "HomeIcon"
            },
            {
                url: "/Mantenedor/Anulacion",
                name: "Anulacion",
                slug: "/Mantenedor/Anulacion",
                icon: "HomeIcon"
            },
            {
                url: "/Mantenedor/Usuario",
                name: "Usuario",
                slug: "/Mantenedor/Usuario",
                icon: "HomeIcon"
            },
            {
                url: "/Mantenedor/UsuariosAuthRetiro",
                name: "Autorizado Retiro",
                slug: "/Mantenedor/UsuariosAuthRetiro",
                icon: "/Mantenedor/HomeIcon"
            },
            {
                url: "/Mantenedor/Servicios",
                name: "Servicios",
                slug: "/Mantenedor/Servicios",
                icon: "HomeIcon"
            },
            {
                url: "/Mantenedor/AuthEstado",
                name: "Auth. Estado",
                slug: "/Mantenedor/AuthEstado",
                icon: "HomeIcon"
            },
            {
                url: "/Mantenedor/Estado",
                name: "Estado General",
                slug: "/Mantenedor/Estado",
                icon: "HomeIcon"
            },
            {
                url: "/Mantenedor/Bodega",
                name: "Bodega",
                slug: "/Mantenedor/Bodega",
                icon: "HomeIcon"
            },
            {
                url: "/Mantenedor/ArticuloMedicamento",
                name: "Articulo Medicamento",
                slug: "/Mantenedor/ArticuloMedicamento",
                icon: "HomeIcon"
            },
            {
                url: "/Mantenedor/ArticuloInsumoEconomato",
                name: "Articulo Insumo Economato",
                slug: "/Mantenedor/ArticuloInsumoEconomato",
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
                url: "/Recepcion/OrdenCompra",
                name: "OrdenCompra",
                slug: "/Recepcion/OrdenCompra",
                icon: "HomeIcon"
            }
        ]
    },
    {
        url: null,
        name: "Consumo Inmediato",
        slug: "consumoinmediato",
        icon: "HomeIcon",
        submenu: [
            {
                url: "/ConsumoInmediato/Recepcion",
                name: "Recepcion",
                slug: "/ConsumoInmediato/Recepcion",
                icon: "HomeIcon"
            },
            {
                url: "/ConsumoInmediato/ListaRecepcion",
                name: "ListaRecepcion",
                slug: "/ConsumoInmediato/ListaRecepcion",
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
                url: "/Despacho/DespachoPEspeciales",
                name: "DespachoPEspeciales",
                slug: "/Despacho/DespachoPEspeciales",
                icon: "HomeIcon"
            },
            {
                url: "/Despacho/SolicitudPedidos",
                name: "SolicitudPedidos",
                slug: "/Despacho/SolicitudPedidos",
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
                url: "/Reportes/SaldoXProducto",
                name: "SaldoXProducto",
                slug: "/Reportes/SaldoXProducto",
                icon: "HomeIcon"
            }
        ]
    }
];
