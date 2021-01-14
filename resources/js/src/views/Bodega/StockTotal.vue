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

            <!-- @on-row-click="rowClick" -->
            <div class="vx-row mb-12">
                <div class="vx-col w-1/2 mt-5">
                    <vs-button @click="activePrompt = true">Exportar</vs-button>
                </div>
                <div class="vx-col w-1/4 mt-5"></div>
                <div class="vx-col w-1/4 mt-5">
                    <h6>Buscar:</h6>
                    <vs-input
                        id="basicInput"
                        placeholder=""
                        v-model="searchTerm"
                        class="w-full"
                    />
                </div>
            </div>

            <vue-good-table
                :columns="columns"
                :rows="listadoStock"
                :search-options="{
                    enabled: true,
                    externalQuery: searchTerm
                }"
                :pagination-options="{
                    enabled: true,
                    perPage: pageLength
                }"
            >
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
import vSelect from "vue-select";
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
// import the styles
import "vue-good-table/dist/vue-good-table.css";

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
        vSelect,
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
            pageLength: 10,
            dir: false,
            searchTerm: "",
            fileName: "",
            formats: ["xlsx", "csv", "txt"],
            cellAutoWidth: true,
            selectedFormat: "xlsx",
            headerTitle: [
                "ID",
                "Material",
                "Tipo Material",
                "Total Unidades Stock",
                "Total Medida Calculada"
            ],
            headerVal: [
                "id",
                "descripcion_material",
                "descripcion_tipo_material",
                "total",
                "total_cal"
            ],
            columns: [
                {
                    label: "ID",
                    field: "id",
                    type: "number"
                },
                {
                    label: "Material",
                    field: "descripcion_material"
                },
                {
                    label: "Tipo Material",
                    field: "descripcion_tipo_material"
                },
                {
                    label: "Total Unidades Stock",
                    field: "total",
                    type: "number"
                },
                {
                    label: "Total Medida Calculada",
                    field: "total_cal",
                    type: "number"
                }
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
        },
        cargarStock() {
            axios
                .get(this.localVal + "/api/Bodega/GetTotalStock", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    let c = res.data;
                    let b = [];
                    let tipoMedida = "";
                    let medidaFija = "";
                    let count = 0;
                    c.forEach((value, index) => {
                        count = count + 1;
                        if (value.id_material_medida == 1) {
                            tipoMedida = "Litros";
                            medidaFija = "Unidades";
                        } else if (value.id_material_medida == 2) {
                            tipoMedida = "Metros";
                            medidaFija = "Unidades";
                        } else if (value.id_material_medida == 3) {
                            tipoMedida = "Metros";
                            medidaFija = "Unidades";
                        } else if (value.id_material_medida == 4) {
                            tipoMedida = "Metros";
                            medidaFija = "Unidades";
                        } else if (value.id_material_medida == 5) {
                            tipoMedida = "Kilos";
                            medidaFija = "Unidades";
                        } else if (value.id_material_medida == 6) {
                            tipoMedida = "Kilos";
                            medidaFija = "Unidades";
                        } else if (value.id_material_medida == 7) {
                            tipoMedida = "Metros";
                            medidaFija = "Unidades";
                        } else if (value.id_material_medida == 8) {
                            tipoMedida = "Unidades";
                            medidaFija = "Unidades";
                        } else if (value.id_material_medida == 9) {
                            tipoMedida = "Metros";
                            medidaFija = "Unidades";
                        } else if (value.id_material_medida == 10) {
                            tipoMedida = "Kilos";
                            medidaFija = "Unidades";
                        } else if (value.id_material_medida == 11) {
                            tipoMedida = "Litros";
                            medidaFija = "Unidades";
                        } else if (value.id_material_medida == 14) {
                            tipoMedida = "Litros";
                            medidaFija = "Unidades";
                        } else if (value.id_material_medida == 15) {
                            tipoMedida = "Litros";
                            medidaFija = "Unidades";
                        } else if (value.id_material_medida == 16) {
                            tipoMedida = "Kilos";
                            medidaFija = "Unidades";
                        } else if (value.id_material_medida == 17) {
                            tipoMedida = "Litros";
                            medidaFija = "Galones";
                        } else if (value.id_material_medida == 19) {
                            tipoMedida = "Unidades";
                            medidaFija = "Cajas";
                        } else if (value.id_material_medida == 20) {
                            tipoMedida = "Metros";
                            medidaFija = "Planchas";
                        }
                        let objeto = {
                            id: count,
                            descripcion_material: value.descripcion_material,
                            descripcion_tipo_material:
                                value.descripcion_tipo_material,
                            total: value.total + " " + medidaFija,
                            total_cal: value.total_cal + " " + tipoMedida
                        };

                        b.push(objeto);
                    });
                    this.listadoStock = b;
                });
        }
    },
    created() {
        this.cargarStock();
    }
};
</script>
