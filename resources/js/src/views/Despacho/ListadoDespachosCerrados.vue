<template>
    <div>
        <vx-card title="Listado Despachos Cerrados">
            <br />
            <div>
                <vx-card>
                    <vue-good-table
                        :columns="columns"
                        :rows="rows"
                        :pagination-options="PageOptions"
                        styleClass="vgt-table condensed bordered"
                    >
                        <template slot="table-row" slot-scope="props">
                            <!-- Column: Name -->
                            <span
                                v-if="props.column.field === 'fullName'"
                                class="text-nowrap"
                            >
                            </span>
                            <span v-else-if="props.column.field === 'action'">
                                <file-plus-icon
                                    content="Ir al Despacho"
                                    v-tippy
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        redireccionarDespachosCerrados(
                                            props.row.NUMINT
                                        )
                                    "
                                ></file-plus-icon>
                                <edit-icon
                                    content="Ir al Despacho Modificable"
                                    v-tippy
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        redireccionarDespachosCerradosExtra(
                                            props.row.NUMINT
                                        )
                                    "
                                ></edit-icon>
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
import { FilePlusIcon } from "vue-feather-icons";
import { EditIcon } from "vue-feather-icons";
import Vue from "vue";
import VueTippy, { TippyComponent } from "vue-tippy";
import store from "../ScriptMenus/store.js";
Vue.use(VueTippy);
Vue.component("tippy", TippyComponent);

export default {
    components: {
        VueGoodTable,
        PlusCircleIcon,
        FilePlusIcon,
        EditIcon
    },
    data() {
        return {
            //Datos Locales - Variables de Entorno
            localVal: process.env.MIX_APP_URL,
            //Datos Campos
            idMod: 0,
            PageOptions: store.state.PageOptions,
            //Template Columnas Listado
            columns: [
                {
                    label: "N° Interno",
                    field: "NUMINT",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Folio Despacho",
                    field: "FOLIO",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Fecha Despacho",
                    field: "FECDES",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Centro de Costo",
                    field: "NOMSER",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "N° Libro Pedido",
                    field: "NUMLIBRO",
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
        TraerDespachosCerrados() {
            try {
                axios
                    .get(
                        this.localVal + "/api/Despachos/GetDespachosCerrados",
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + localStorage.getItem("token")
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
        redireccionarDespachosCerrados(numinterno) {
            try {
                this.$router.push({
                    name: "DespachoCerrado",
                    params: {
                        NUMINT: `${numinterno}`
                    }
                });
            } catch (error) {
                console.log(error);
            }
        },
        redireccionarDespachosCerradosExtra(numinterno) {
            try {
                this.$router.push({
                    name: "DespachoCerradoExtra",
                    params: {
                        NUMINT: `${numinterno}`
                    }
                });
            } catch (error) {
                console.log(error);
            }
        },
        RefreshToken() {
            try {
                let data = {
                    token: localStorage.getItem("token")
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
                            window.localStorage.clear();
                            window.localStorage.clear();
                            router.push("/pages/login");
                        } else {
                            localStorage.setItem("token", tok);
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        }
    },
    beforeMount() {
        this.RefreshToken();
        setTimeout(() => {
            this.TraerDespachosCerrados();
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
