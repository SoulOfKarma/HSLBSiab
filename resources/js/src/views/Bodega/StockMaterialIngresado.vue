<template>
    <div>
        <vx-card title="1. Listado de Material Ingresado">
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
            <!-- <vs-table
                :data="listadoStock"
                search
                max-items="15"
                pagination
                v-model="busqueda"
            >
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
                            <plus-circle-icon
                                size="1.5x"
                                class="custom-class"
                                @click="modificarMaterial(data[indextr].id)"
                            ></plus-circle-icon>
                            <archive-icon
                                size="1.5x"
                                class="custom-class"
                                @click="generarBarCode(data[indextr].id)"
                            ></archive-icon>
                        </vs-td>
                    </vs-tr>
                </template>
            </vs-table> -->
            <!-- search input -->
            <div class="vx-row mb-12">
                <div class="vx-col w-1/2 mt-5">
                    <vs-button @click="activePrompt = true">Exportar</vs-button>
                </div>
                <div class="vx-col w-1/4 mt-5"></div>
                <div class="vx-col w-1/4 mt-5">
                    <h6>Buscar:</h6>
                    <vs-input
                        id="basicInput"
                        placeholder="Ej. 5"
                        v-model="searchTerm"
                        class="w-full"
                        @keyup.enter="buscarPorId()"
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
                            @click="informacionGeneral(props.row.id)"
                        ></info-icon>
                        <plus-circle-icon
                            size="1.5x"
                            class="custom-class"
                            @click="modificarMaterial(props.row.id)"
                        ></plus-circle-icon>
                        <!-- <archive-icon
                            size="1.5x"
                            class="custom-class"
                            @click="generarBarCode(props.row.id)"
                        ></archive-icon> -->
                    </span>

                    <!-- Column: Common -->
                    <span v-else>
                        {{ props.formattedRow[props.column.field] }}
                    </span>
                </template>
            </vue-good-table>
        </vx-card>
        <vs-popup
            classContent="pop-Crear"
            title="Codigo de Barra"
            :active.sync="popActiveBarCode"
        >
            <div class="vx-col md:w-1/1 w-full mb-base">
                <div class="vx-row">
                    <div class="w-1/5"></div>
                    <div class="w-1/5"></div>
                    <div class="w-1/5" id="printJS-form">
                        <barcode v-bind:value="valueCode">
                            No es posible generar el codigo
                        </barcode>
                    </div>
                    <div class="w-1/5"></div>
                    <div class="w-1/5"></div>
                    <div class="w-1/5"></div>
                    <div class="w-1/5"></div>
                    <div class="w-1/5">
                        <vs-button
                            class="w-full"
                            icon-pack="feather"
                            icon="icon icon-file"
                            @click="printInvoice"
                            >Imprimir</vs-button
                        >
                    </div>
                    <div class="w-1/5"></div>
                    <div class="w-1/5"></div>
                </div>
            </div>
        </vs-popup>
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
import VueBarcode from "vue-barcode";
import pdfMake from "pdfmake/build/pdfmake";
import pdfFonts from "pdfmake/build/vfs_fonts";
pdfMake.vfs = pdfFonts.pdfMake.vfs;
import html2canvas from "html2canvas";
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
        barcode: VueBarcode,
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
            columns: [
                {
                    label: "ID",
                    field: "id",
                    type: "number"
                },
                {
                    label: "Ubicacion",
                    field: "descripcion_ubicacion"
                },
                {
                    label: "Cubiculo",
                    field: "descripcion_cubiculo"
                },
                {
                    label: "Material",
                    field: "descripcion_material"
                },
                {
                    label: "Medida",
                    field: "descripcion_medidas"
                },
                {
                    label: "Cantidad",
                    field: "material_cantidad"
                },
                {
                    label: "Valor",
                    field: "material_valor"
                },
                {
                    label: "Tipo Documento",
                    field: "descripcion_documento"
                },
                {
                    label: "N° Documento",
                    field: "n_documento"
                },
                {
                    label: "Opciones",
                    field: "action"
                }
            ],
            fileName: "",
            formats: ["xlsx", "csv", "txt"],
            cellAutoWidth: true,
            selectedFormat: "xlsx",
            headerTitle: [
                "ID",
                "Ubicacion",
                "Cubiculo",
                "Material",
                "Medida",
                "Cantidad",
                "Valor",
                "Tipo Documento",
                "N° Documento",
                "Fecha Registro"
            ],
            headerVal: [
                "id",
                "descripcion_ubicacion",
                "descripcion_cubiculo",
                "descripcion_material",
                "descripcion_medidas",
                "material_cantidad",
                "material_valor",
                "descripcion_documento",
                "n_documento",
                "created"
            ],
            activePrompt: false,
            listadoStock: [],
            listadoTipoMaterial: [],
            listadoTipoMaterialData: [],
            nombre:
                sessionStorage.getItem("nombre") +
                " " +
                sessionStorage.getItem("apellido"),
            run: sessionStorage.getItem("run"),
            localVal: process.env.MIX_APP_URL,
            popActiveBarCode: false,
            valueCode: 0,
            busqueda: 0
        };
    },
    methods: {
        buscarPorId() {
            try {
                let c = this.listadoTipoMaterialData;
                let b = [];
                let a = 0;
                c.forEach((value, index) => {
                    a = value.id;
                    if (a == this.searchTerm) {
                        b.push(value);
                    }
                });
                this.searchTerm = b[0].descripcion_tipo_material;
            } catch (error) {
                console.log("No Existe Material Activo Registrado");
            }
        },
        async printInvoice() {
            //this.$refs.easyPrint.print();
            //window.print();
            html2canvas(document.getElementById("printJS-form")).then(
                canvas => {
                    var imgWidth = 100;
                    var pageHeight = 90;
                    var imgHeight = (canvas.height * imgWidth) / canvas.width;
                    var heightLeft = imgHeight;
                    var options = {
                        size: "80px",
                        background: "#fff",
                        pagesplit: true
                    };
                    const data = canvas.toDataURL("image/png");

                    var docDefinition = {
                        pageSize: {
                            width: 150,
                            height: "auto"
                        },
                        styles: {
                            rightme: {
                                alignment: "center"
                            }
                        },
                        content: [
                            {
                                image: data,
                                width: 100,
                                style: "rightme"
                            }
                        ]
                    };
                    pdfMake.createPdf(docDefinition).open();
                }
            );

            /*  {
                onrendered: function(canvas) {
                    var data = canvas.toDataURL("image/png");
                    var docDefinition = {
                        content: [
                            {
                                image: data,
                                width: 500
                            }
                        ]
                    };

                    pdfMake
                        .createPdf(docDefinition)
                        .download("Score_Details.pdf");
                }
            } */
        },
        generarBarCode(id) {
            this.popActiveBarCode = true;
            this.valueCode = id;
        },
        modificarMaterial(id) {
            this.$router.push({
                name: "modificarMaterial",
                params: {
                    id: `${id}`
                }
            });
        },
        informacionGeneral(id) {
            this.$router.push({
                name: "seguimientoMaterial",
                params: {
                    id: `${id}`
                }
            });
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
