<!-- =========================================================================================
    File Name: Login.vue
    Description: Login Page
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
      Author: Pixinvent
    Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->

<template>
    <div>
        <vx-card title="Listado Documentos Firmados" class="text-center">
            <div>
                <vs-row>
                    <vs-col
                        vs-offset="1"
                        v-tooltip="'col - 10'"
                        vs-type="flex"
                        vs-justify="center"
                        vs-align="center"
                        vs-w="10"
                    >
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
                                    <span
                                        v-else-if="
                                            props.column.field === 'action'
                                        "
                                    >
                                        <plus-circle-icon
                                            content="Ir a la Recepcion"
                                            v-tippy
                                            size="1.5x"
                                            class="custom-class"
                                            @click="
                                                VerFirmantes(props.row.FOLIO)
                                            "
                                        ></plus-circle-icon>
                                    </span>
                                    <!-- Column: Common -->
                                    <span v-else>
                                        {{
                                            props.formattedRow[
                                                props.column.field
                                            ]
                                        }}
                                    </span>
                                </template>
                            </vue-good-table>
                        </vx-card>
                    </vs-col>
                </vs-row>
            </div>
        </vx-card>
    </div>
</template>

<script>
import axios from "axios";
import router from "../../router";
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
            //Datos Campos
            idMod: 0,
            //Template Columnas Listado Proveedor
            columns: [
                {
                    label: "N° Folio",
                    field: "FOLIO",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Servicio",
                    field: "descripcionServicio",
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
        TraerRecepcionesAbiertas() {
            try {
                axios
                    .get(
                        this.localVal + "/api/Mantenedor/GetRecepcionAbiertas",
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
        VerFirmantes(folio) {
            try {
            } catch (error) {
                console.log(error);
            }
        }
    }
};
</script>

<style lang="scss">
#login-box {
    width: 360px;
}
.h-screen {
    background-image: linear-gradient(rgb(233, 236, 239), rgb(49, 215, 129));
}

.con-vs-popup .vs-popup {
    width: 1000px;
}
</style>
