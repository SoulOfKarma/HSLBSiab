<template>
    <div>
        <vx-card title="Listado Recepciones Cerradas">
            <br />
            <div>
                <vx-card>
                    <vue-good-table
                        :columns="columns"
                        :rows="rows"
                        :pagination-options="{
                            enabled: true,
                            perPage: 10
                        }"
                    >
                        <template slot="table-row" slot-scope="props">
                            <!-- Column: Name -->
                            <span
                                v-if="props.column.field === 'fullName'"
                                class="text-nowrap"
                            >
                            </span>
                            <span v-else-if="props.column.field === 'NOMARCH'">
                                <plus-circle-icon
                                    content="Abrir Factura"
                                    v-tippy
                                    size="1.5x"
                                    class="custom-class"
                                    @click="abrirFactura(props.row.NOMARCH)"
                                ></plus-circle-icon>
                            </span>
                            <span
                                v-else-if="props.column.field === 'NOMARCH_RIB'"
                            >
                                <plus-circle-icon
                                    content="Abrir RIB"
                                    v-tippy
                                    size="1.5x"
                                    class="custom-class"
                                    @click="abrirRIB(props.row.NOMARCH_RIB)"
                                ></plus-circle-icon>
                            </span>
                            <span
                                v-else-if="props.column.field === 'NOMARCH_CAR'"
                            >
                                <plus-circle-icon
                                    content="Abrir Carta"
                                    v-tippy
                                    size="1.5x"
                                    class="custom-class"
                                    @click="abrirCarta(props.row.NOMARCH_CAR)"
                                ></plus-circle-icon>
                            </span>
                            <span v-else-if="props.column.field === 'action'">
                                <plus-circle-icon
                                    content="Ir a la Recepcion Cerrada"
                                    v-tippy
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        redireccionarRecepcion(props.row.NUMINT)
                                    "
                                ></plus-circle-icon>
                            </span>
                            <!-- Column: Common -->
                            <span v-else>
                                {{ props.formattedRow[props.column.field] }}
                            </span>
                        </template>
                    </vue-good-table>
                </vx-card>
            </div>
        </vx-card>
    </div>
</template>
<script>
import axios from "axios";
import router from "@/router";
import "vue-good-table/dist/vue-good-table.css";
import { VueGoodTable } from "vue-good-table";
import { PlusCircleIcon } from "vue-feather-icons";
import Vue from "vue";
import VueTippy, { TippyComponent } from "vue-tippy";
Vue.use(VueTippy);
Vue.component("tippy", TippyComponent);

export default {
    components: {
        VueGoodTable,
        PlusCircleIcon
    },
    data() {
        return {
            //Datos Locales - Variables de Entorno
            localVal: process.env.MIX_APP_URL,
            localDoc: process.env.MIX_APP_URL_DOCUMENTOS,
            //Datos Campos
            idMod: 0,
            //Template Columnas Listado Proveedor
            columns: [
                {
                    label: "N° Interno",
                    field: "NUMINT",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Folio",
                    field: "FOLIO",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "N° Orden Compra",
                    field: "NUMORD",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Fecha Recepcion",
                    field: "FECDES",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Rut Proveedor",
                    field: "RUTPRO",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Nombre Proveedor",
                    field: "NOMPRO",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "N° Documento",
                    field: "NUMDOC",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "N° RIB",
                    field: "NUMINT",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Usuario",
                    field: "USUING",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Observaciones",
                    field: "OBS",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Ver Factura",
                    field: "NOMARCH"
                },
                {
                    label: "Ver RIB",
                    field: "NOMARCH_RIB"
                },
                {
                    label: "Ver Carta",
                    field: "NOMARCH_CAR"
                },
                {
                    label: "Opciones",
                    field: "action"
                }
            ],
            //Datos Listado
            rows: []
        };
    },
    methods: {
        //Metodos Reusables
        openLoadingColor() {
            this.$vs.loading({ color: this.colorLoading });
            setTimeout(() => {
                this.$vs.loading.close();
            }, 1000);
        },
        //Metodos CRUD
        TraerRecepcionesCerradas() {
            try {
                axios
                    .get(
                        this.localVal + "/api/Mantenedor/GetRecepcionCerradas",
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.rows = res.data;
                        if (this.rows.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        RefreshToken() {
            try {
                let data = {
                    token: sessionStorage.getItem("token")
                };
                axios
                    .post(this.localVal + "/api/auth/RefreshToken", data)
                    .then(res => {
                        let tok = res.data;
                        if (tok == "") {
                        } else if (tok == false) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No se pudo refrescar su sesion, sera redirigido a el inicio de sesion",
                                color: "danger",
                                position: "top-right"
                            });
                            window.sessionStorage.clear();
                            window.localStorage.clear();
                            router.push("/pages/login");
                        } else {
                            sessionStorage.setItem("token", tok);
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        redireccionarRecepcion(numinterno) {
            try {
                this.$router.push({
                    name: "RecepcionCerrada",
                    params: {
                        NUMINT: `${numinterno}`
                    }
                });
            } catch (error) {
                console.log(error);
            }
        },
        abrirFactura(doc) {
            try {
                const url = this.localDoc + "/" + doc;
                window.open(url, "_blank");
            } catch (error) {
                console.log(error);
            }
        },
        abrirRIB(doc) {
            try {
                const url = this.localDoc + "/" + doc;
                window.open(url, "_blank");
            } catch (error) {
                console.log(error);
            }
        },
        abrirCarta(doc) {
            try {
                const url = this.localDoc + "/" + doc;
                window.open(url, "_blank");
            } catch (error) {
                console.log(error);
            }
        }
    },
    beforeMount() {
        this.RefreshToken();
        setTimeout(() => {
            this.TraerRecepcionesCerradas();
            this.openLoadingColor();
        }, 2000);
    }
};
</script>
<style lang="stylus">
.con-vs-popup .vs-popup {
  width: 1000px;
}
</style>
