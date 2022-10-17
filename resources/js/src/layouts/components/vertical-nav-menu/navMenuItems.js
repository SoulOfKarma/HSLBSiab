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
                url: "/Mantenedor/TipoCompra",
                name: "Tipo Compra",
                slug: "/Mantenedor/TipoCompra",
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
                url: "/Mantenedor/IngresoArticulos",
                name: "Ingreso Articulos",
                slug: "/Mantenedor/IngresoArticulos",
                icon: "HomeIcon"
            },
            {
                url: "/Mantenedor/StockMinMax",
                name: "Stock Articulos",
                slug: "/Mantenedor/StockMinMax",
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
        name: "Orden Compra",
        slug: "OrdenCompra",
        icon: "HomeIcon",
        submenu: [
            {
                url: "/OrdenCompra/OrdenCompra",
                name: "Orden Compra",
                slug: "/OrdenCompra/OrdenCompra",
                icon: "HomeIcon"
            },
            {
                url: "/OrdenCompra/ListadoOrdenCompraAbierta",
                name: "Lista OC Abierta",
                slug: "/OrdenCompra/ListadoOrdenCompraAbierta",
                icon: "HomeIcon"
            },
            {
                url: "/OrdenCompra/ListadoOrdenCompraCerrada",
                name: "Lista OC Cerrada",
                slug: "/OrdenCompra/ListadoOrdenCompraCerrada",
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
    }
];
