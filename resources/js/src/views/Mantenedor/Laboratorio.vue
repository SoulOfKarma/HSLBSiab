<template>
    <div>
        <vx-card title="Laboratorio">
            <div>
                <vs-button color="primary" type="filled" @click="popLaboratorio"
                    >Agregar Laboratorio</vs-button
                >
            </div>
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
                            <span v-else-if="props.column.field === 'action'">
                            </span>
                            <!-- Column: Common -->
                            <span v-else>
                                {{ props.formattedRow[props.column.field] }}
                            </span>
                        </template>
                    </vue-good-table>
                </vx-card>
            </div>
            <vs-popup
                classContent="Laboratorio"
                title="Agregar Laboratorio"
                :active.sync="popUpLaboratorio"
            >
                <div class="vx-col md:w-1/1 w-full mb-base">
                    <vx-card title="">
                        <div class="vx-row ">
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Nombre Laboratorio</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    v-model="nomLaboratorio"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Razon Social</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    v-model="razonSocial"
                                />
                            </div>
                        </div>
                        <div class="vx-row">
                            <div class="vx-col w-full md-5">
                                <vs-button
                                    @click="popUpLaboratorio = false"
                                    color="primary"
                                    type="filled"
                                    class="w-full m-1"
                                    >Volver</vs-button
                                >
                                <vs-button
                                    @click="AgregarLaboratorio"
                                    color="danger"
                                    type="filled"
                                    class="w-full m-1"
                                    >Agregar Laboratorio</vs-button
                                >
                            </div>
                        </div>
                    </vx-card>
                    <div class="vx-row"></div>
                </div>
            </vs-popup>
        </vx-card>
    </div>
</template>
<script>
import axios from "axios";
import vSelect from "vue-select";
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import "quill/dist/quill.bubble.css";
import { quillEditor } from "vue-quill-editor";
import "vue-good-table/dist/vue-good-table.css";
import { VueGoodTable } from "vue-good-table";

export default {
    components: {
        VueGoodTable,
        "v-select": vSelect,
        quillEditor
    },
    data() {
        return {
            //Datos Locales - Variables de Entorno
            localVal: process.env.MIX_APP_URL,
            editorOption: {
                modules: {
                    toolbar: [
                        ["bold", "italic", "underline", "strike"],
                        ["blockquote", "code-block"],
                        [{ header: 1 }, { header: 2 }],
                        [{ list: "ordered" }, { list: "bullet" }],
                        [{ indent: "-1" }, { indent: "+1" }],
                        [{ direction: "rtl" }],
                        [{ font: [] }],
                        [{ align: [] }],
                        ["clean"]
                    ]
                }
            },
            //Datos Campos
            popUpLaboratorio: false,
            nomLaboratorio: "",
            razonSocial: "",
            //Template Columnas Listado Proveedor
            columns: [
                {
                    label: "Name",
                    field: "name",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Age",
                    field: "age",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Opciones",
                    field: "action"
                }
            ],
            //Datos Listado Proveedor
            rows: [
                { id: 1, name: "John", age: 20 },
                {
                    id: 2,
                    name: "Jane",
                    age: 24
                },
                {
                    id: 3,
                    name: "Susan",
                    age: 16
                },
                {
                    id: 4,
                    name: "Chris",
                    age: 55
                },
                {
                    id: 5,
                    name: "Dan",
                    age: 40
                },
                {
                    id: 6,
                    name: "John",
                    age: 20
                }
            ]
        };
    },
    methods: {
        //Metodos Reusables
        isNumber: function(evt) {
            evt = evt ? evt : window.event;
            var charCode = evt.which ? evt.which : evt.keyCode;
            if (
                charCode > 31 &&
                (charCode < 48 || charCode > 57) &&
                charCode !== 46
            ) {
                evt.preventDefault();
            } else {
                return true;
            }
        },
        //PopUp
        popLaboratorio() {
            try {
                this.popUpLaboratorio = true;
            } catch (error) {
                console.log(error);
            }
        },
        //Metodos para Agregar Datos
        AgregarLaboratorio() {
            try {
                console.log("Mensaje :T");
            } catch (error) {
                console.log(error);
            }
        }
    }
};
</script>
<style lang="stylus">
.con-vs-popup .vs-popup {
  width: 1000px;
}
</style>
