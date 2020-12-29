<template>
    <div>
        <vx-card title="1. Listado de Tickets">
            <vs-alert active="true" color="success">
                Agente:
                {{ nombre }} - {{ run }}
            </vs-alert>
            <vs-prompt
                title="Exportar a Excel"
                class="export-options"
                @cancle="clearFields"
                @accept="exportToExcel"
                accept-text="Export"
                @close="clearFields"
                :active.sync="activePrompt"
            >
                <vs-input
                    v-model="fileName"
                    placeholder="Escriba el nombre del archivo..."
                    class="w-full"
                />
                <v-select
                    v-model="selectedFormat"
                    :options="formats"
                    class="my-4"
                />
                <div class="flex">
                    <span class="mr-4">Cell Auto Width:</span>
                    <vs-switch v-model="cellAutoWidth"
                        >Cell Auto Width</vs-switch
                    >
                </div>
            </vs-prompt>
            <vs-table :data="listadoStock" search max-items="15" pagination>
                <template slot="header">
                    <vs-button @click="activePrompt = true">Exportar</vs-button>
                </template>
                <template slot="thead">
                    <vs-th>ID</vs-th>
                    <vs-th>Ubicacion</vs-th>
                    <vs-th>Servicio</vs-th>
                    <vs-th>Material</vs-th>
                    <vs-th>Tipo Material</vs-th>
                    <vs-th>Contenido</vs-th>
                    <vs-th>Medida</vs-th>
                    <vs-th>Cantidad</vs-th>
                    <vs-th>Valor</vs-th>
                    <vs-th>Tipo Documento</vs-th>
                    <vs-th>N° Documento</vs-th>
                    <vs-th>Opciones</vs-th>
                </template>

                <template slot-scope="{ data }">
                    <vs-tr :key="indextr" v-for="(tr, indextr) in data">
                        <vs-td :data="data[indextr].id">
                            {{ data[indextr].id }}
                        </vs-td>

                        <vs-td :data="data[indextr].descripcion_ubicacion">
                            {{ data[indextr].descripcion_ubicacion }}
                        </vs-td>

                        <vs-td :data="data[indextr].descripcion_servicio">
                            {{ data[indextr].descripcion_servicio }}
                        </vs-td>

                        <vs-td :data="data[indextr].descripcion_material">
                            {{ data[indextr].descripcion_material }}
                        </vs-td>
                        <vs-td :data="data[indextr].descripcion_tipo_material">
                            {{ data[indextr].descripcion_tipo_material }}
                        </vs-td>
                        <vs-td
                            :data="
                                data[indextr].descripcion_cantidad_especifica
                            "
                        >
                            {{ data[indextr].descripcion_cantidad_especifica }}
                        </vs-td>
                        <vs-td :data="data[indextr].descripcion_medidas">
                            {{ data[indextr].descripcion_medidas }}
                        </vs-td>
                        <vs-td :data="data[indextr].material_cantidad">
                            {{ data[indextr].material_cantidad }}
                        </vs-td>
                        <vs-td :data="data[indextr].material_valor">
                            ${{ data[indextr].material_valor }}
                        </vs-td>
                        <vs-td :data="data[indextr].descripcion_documento">
                            {{ data[indextr].descripcion_documento }}
                        </vs-td>
                        <vs-td :data="data[indextr].n_documento">
                            {{ data[indextr].n_documento }}
                        </vs-td>
                        <vs-td :data="data[indextr].id">
                            <info-icon
                                size="1.5x"
                                class="custom-class"
                                @click="informacionGeneral(data[indextr].id)"
                            ></info-icon>
                        </vs-td>
                    </vs-tr>
                </template>
            </vs-table>
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
import vSelect from "vue-select";

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
        vSelect
    },
    data() {
        return {
            fileName: "",
            formats: ["xlsx", "csv", "txt"],
            cellAutoWidth: true,
            selectedFormat: "xlsx",
            headerTitle: [
                "ID",
                "Ubicacion",
                "Servicio",
                "Material",
                "Tipo Material",
                "Contenido",
                "Medida",
                "Cantidad",
                "Valor",
                "Tipo Documento",
                "N° Documento"
            ],
            headerVal: [
                "id",
                "descripcion_ubicacion",
                "descripcion_servicio",
                "descripcion_material",
                "descripcion_tipo_material",
                "descripcion_cantidad_especifica",
                "descripcion_medidas",
                "material_cantidad",
                "material_valor",
                "descripcion_documento",
                "n_documento"
            ],
            activePrompt: false,
            listadoStock: [],
            nombre:
                sessionStorage.getItem("nombre") +
                " " +
                sessionStorage.getItem("apellido"),
            run: sessionStorage.getItem("run"),
            localVal: process.env.MIX_APP_URL
        };
    },
    methods: {
        informacionGeneral(id) {
            console.log(id);
        },
        cargarStock() {
            axios
                .get(this.localVal + "/api/Bodega/GetStock", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoStock = res.data;
                });
        },
        exportToExcel() {
            import("@/vendor/Export2Excel").then(excel => {
                const list = this.listadoStock;
                const data = this.formatJson(this.headerVal, list);
                excel.export_json_to_excel({
                    header: this.headerTitle,
                    data,
                    filename: this.fileName,
                    autoWidth: this.cellAutoWidth,
                    bookType: this.selectedFormat
                });
                this.clearFields();
            });
        },
        formatJson(filterVal, jsonData) {
            return jsonData.map(v =>
                filterVal.map(j => {
                    // Add col name which needs to be translated
                    // if (j === 'timestamp') {
                    //   return parseTime(v[j])
                    // } else {
                    //   return v[j]
                    // }

                    return v[j];
                })
            );
        },
        clearFields() {
            this.filename = "";
            this.cellAutoWidth = true;
            this.selectedFormat = "xlsx";
        }
    },
    created() {
        this.cargarStock();
    }
};
</script>
