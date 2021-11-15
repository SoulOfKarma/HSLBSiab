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
                :rows="listaRMaterial"
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

                    <!-- Column: Action -->
                    <span v-else-if="props.column.field === 'action'">
                        <info-icon
                            size="1.5x"
                            class="custom-class"
                            @click="informacionGeneral(props.row.id_ticket)"
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
            pageLength: 10,
            dir: false,
            listaRMaterial: [],
            columns: [
                {
                    label: "ID",
                    field: "id",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "N° Ticket",
                    field: "id_ticket",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Descripcion Material",
                    field: "descripcion_material",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Material Cantidad",
                    field: "material_cantidad",
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
        cargarRMaterial() {
            try {
                axios
                    .get(this.localVal + "/api/Bodega/GetRMateriales", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listaRMaterial = res.data;
                    });
            } catch (error) {
                console.log("Hubo un error al cargar los datos");
            }
        },
        informacionGeneral(idticket) {
            try {
                let id = idticket;
                this.$router.push({
                    name: "retornarMaterialList",
                    params: {
                        id_ticket: `${id}`
                    }
                });
            } catch (error) {
                console.log("Hubo un problema al redireccionar");
            }
        }
    },
    created() {
        this.cargarRMaterial();
    }
};
</script>
