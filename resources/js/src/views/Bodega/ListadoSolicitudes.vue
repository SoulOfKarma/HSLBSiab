<template>
    <div>
        <vx-card title="1. Listado de Tickets">
            <vs-alert active="true" color="success">
                Agente:
                {{ nombre }} - {{ run }}
            </vs-alert>
            <br />
            <vue-good-table
                :key="componentKey"
                :columns="columns"
                :rows="listadoTickets"
                :pagination-options="{
                    enabled: true,
                    perPage: pageLength
                }"
            >
                <template slot="table-row" slot-scope="props">
                    <!-- Column: Name -->
                    <span
                        v-if="props.column.field === 'fullName'"
                        class="text-nowrap"
                    >
                    </span>
                    <!-- Column: Descripcion -->
                    <span v-if="props.column.field == 'descripcionP'">
                        <span v-html="props.row.descripcionP"></span>
                    </span>

                    <!-- Column: Action -->
                    <span v-else-if="props.column.field === 'action'">
                        <info-icon
                            size="1.5x"
                            class="custom-class"
                            @click="
                                informacionGeneral(props.row.id, props.row.uuid)
                            "
                        ></info-icon>
                    </span>

                    <!-- Column: Common -->
                    <span v-else>
                        {{ props.formattedRow[props.column.field] }}
                    </span>
                </template>
            </vue-good-table>
        </vx-card>
    </div>
</template>
<script>
import axios from "axios";
import router from "@/router";
import { InfoIcon } from "vue-feather-icons";
import { PlusCircleIcon } from "vue-feather-icons";
import { Trash2Icon } from "vue-feather-icons";
import { UploadIcon } from "vue-feather-icons";
import { CornerDownRightIcon } from "vue-feather-icons";
import { ArchiveIcon } from "vue-feather-icons";
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import "quill/dist/quill.bubble.css";
import { quillEditor } from "vue-quill-editor";
import Vue from "vue";
import Vuesax from "vuesax";
// import the styles
import "vue-good-table/dist/vue-good-table.css";
import {
    BAvatar,
    BBadge,
    BPagination,
    BFormSelect,
    BDropdown,
    BDropdownItem
} from "bootstrap-vue";
import { BFormInput, BRow, BCol, BFormGroup } from "bootstrap-vue";
import { VueGoodTable } from "vue-good-table";
import VueGoodTablePlugin from "vue-good-table";

Vue.use(VueGoodTablePlugin);

Vue.use(Vuesax, {
    theme: {
        colors: {
            primary: "#5b3cc4",
            success: "rgb(23, 201, 100)",
            danger: "rgb(242, 19, 93)",
            warning: "rgb(255, 130, 0)",
            dark: "rgb(36, 33, 69)"
        }
    }
});
export default {
    components: {
        ArchiveIcon,
        InfoIcon,
        PlusCircleIcon,
        Trash2Icon,
        UploadIcon,
        CornerDownRightIcon,
        quillEditor,
        VueGoodTable,
        BAvatar,
        BBadge,
        BPagination,
        BFormGroup,
        BFormInput,
        BFormSelect,
        BDropdown,
        BDropdownItem,
        BFormInput,
        BFormGroup,
        BRow,
        BCol
    },
    data() {
        return {
            componentKey: 0,
            nombre:
                sessionStorage.getItem("nombre") +
                " " +
                sessionStorage.getItem("apellido"),
            run: sessionStorage.getItem("run"),
            localVal: process.env.MIX_APP_URL,
            externalVal: process.env.MIX_APP_URL_EXTERNA,
            listadoTickets: [
                {
                    nticket: 0,
                    nombre: "",
                    descripcionp: "",
                    descripcionEstado: ""
                }
            ],
            pageLength: 10,
            dir: false,
            searchTerm: "",
            columns: [
                {
                    label: "Numero Solicitud",
                    field: "nticket",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Persona Solicitante",
                    field: "nombre",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Descripcion Problema",
                    field: "descripcionP",
                    html: true,
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Estado",
                    field: "descripcionEstado",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Categoria",
                    field: "des_categoria",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Opciones",
                    field: "action"
                }
            ]
        };
    },
    methods: {
        forceRerender() {
            this.componentKey += 1;
        },
        informacionGeneral(id, uuid, id_user) {
            this.$router.push({
                name: "entregaMaterialNSolicitud",
                params: {
                    id: `${id}`,
                    uuid: `${uuid}`
                }
            });
        },
        cargarSolicitudesExternas() {
            axios
                .get(this.externalVal + "/api/Agente/ticketsAll", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token_externo")
                    }
                })
                .then(res => {
                    let a = 0;
                    let b = [];
                    let c = res.data;

                    c.forEach((value, index) => {
                        value.nombre = value.nombre + " " + value.apellido;
                        b.push(value);
                    });
                    this.listadoTickets = b;
                });
        },
        cargarTokenExterno() {
            let objeto = { run: "18499714-2", password: "1849" };
            axios
                .post(this.externalVal + "/api/auth/login", objeto)
                .then(res => {
                    sessionStorage.setItem("token_externo", res.data.token);
                })
                .catch(error => console.log(error));
            setTimeout(() => {
                this.cargarSolicitudesExternas();
            }, 2000);
        },
        validarTokenExterno() {
            let tokenexterno = sessionStorage.getItem("token_externo");
            if (tokenexterno == null || tokenexterno == "") {
                console.log("Solicitar Nuevo token");
                this.cargarTokenExterno();
            } else {
                axios
                    .post(this.externalVal + "/api/auth/check", {
                        token: sessionStorage.getItem("token_externo") !== ""
                    })
                    .then(res => {
                        let validador = res.data.success;
                        if (validador == true) {
                            console.log("Se cargara Listado");
                            this.cargarSolicitudesExternas();
                        } else {
                            console.log("Se pedira token nuevo");
                            this.cargarTokenExterno();
                        }
                    });
            }
        }
    },
    created() {
        this.validarTokenExterno();
    }
};
</script>
