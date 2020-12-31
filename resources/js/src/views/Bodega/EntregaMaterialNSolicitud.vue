<template>
    <div>
        <vs-row>
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card>
                    <vs-alert active="true" color="success">
                        Entrega Material - Agente:
                        {{ nombre }} - {{ run }}
                    </vs-alert>
                    <vs-table
                        :data="listadoInventario"
                        search
                        max-items="15"
                        pagination
                        v-model="selected"
                        @selected="handleSelected"
                    >
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
                        </template>

                        <template slot-scope="{ data }">
                            <vs-tr
                                :data="tr"
                                :key="indextr"
                                v-for="(tr, indextr) in data"
                            >
                                <vs-td :data="data[indextr].id">
                                    {{ data[indextr].id }}
                                </vs-td>

                                <vs-td
                                    :data="data[indextr].descripcion_ubicacion"
                                >
                                    {{ data[indextr].descripcion_ubicacion }}
                                </vs-td>

                                <vs-td
                                    :data="data[indextr].descripcion_servicio"
                                >
                                    {{ data[indextr].descripcion_servicio }}
                                </vs-td>

                                <vs-td
                                    :data="data[indextr].descripcion_material"
                                >
                                    {{ data[indextr].descripcion_material }}
                                </vs-td>
                                <vs-td
                                    :data="
                                        data[indextr].descripcion_tipo_material
                                    "
                                >
                                    {{
                                        data[indextr].descripcion_tipo_material
                                    }}
                                </vs-td>
                                <vs-td
                                    :data="
                                        data[indextr]
                                            .descripcion_cantidad_especifica
                                    "
                                >
                                    {{
                                        data[indextr]
                                            .descripcion_cantidad_especifica
                                    }}
                                </vs-td>
                                <vs-td
                                    :data="data[indextr].descripcion_medidas"
                                >
                                    {{ data[indextr].descripcion_medidas }}
                                </vs-td>
                                <vs-td :data="data[indextr].material_cantidad">
                                    {{ data[indextr].material_cantidad }}
                                </vs-td>
                                <vs-td :data="data[indextr].material_valor">
                                    ${{ data[indextr].material_valor }}
                                </vs-td>
                                <vs-td
                                    :data="data[indextr].descripcion_documento"
                                >
                                    {{ data[indextr].descripcion_documento }}
                                </vs-td>
                                <vs-td :data="data[indextr].n_documento">
                                    {{ data[indextr].n_documento }}
                                </vs-td>
                            </vs-tr>
                        </template>
                    </vs-table>
                </vx-card>
                <br />
                <vx-card>
                    <div class="vx-row mb-12">
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.1 - Ubicacion</h6>
                            <br />
                            <vs-input
                                disabled
                                class="inputx w-full"
                                placeholder="Disabled"
                                v-model="materialSeleccion.ubicacion"
                            />
                            <br />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.2 - Servicio</h6>
                            <br />
                            <vs-input
                                disabled
                                class="inputx w-full"
                                placeholder="Disabled"
                                v-model="materialSeleccion.servicio"
                            />
                            <br />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.3 - Material</h6>
                            <br />
                            <vs-input
                                disabled
                                class="inputx w-full"
                                placeholder="Disabled"
                                v-model="materialSeleccion.material"
                            />
                            <br />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.4 - Tipo Material</h6>
                            <br />
                            <vs-input
                                disabled
                                class="inputx w-full"
                                placeholder="Disabled"
                                v-model="materialSeleccion.tipo_material"
                            />
                            <br />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.5 - Contenido</h6>
                            <br />
                            <vs-input
                                disabled
                                class="inputx w-full"
                                placeholder="Disabled"
                                v-model="materialSeleccion.contenido"
                            />
                            <br />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.6 - Medida</h6>
                            <br />
                            <vs-input
                                disabled
                                class="inputx w-full"
                                placeholder="Disabled"
                                v-model="materialSeleccion.medida"
                            />
                            <br />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.7 - Cantidad</h6>
                            <br />
                            <vs-input
                                class="inputx w-full"
                                placeholder="Disabled"
                                v-model="materialSeleccion.cantidad"
                            />
                            <br />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.8 - Valor</h6>
                            <br />
                            <vs-input
                                disabled
                                class="inputx w-full"
                                placeholder="Disabled"
                                v-model="materialSeleccion.valor"
                            />
                            <br />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.9 - Documento</h6>
                            <br />
                            <vs-input
                                disabled
                                class="inputx w-full"
                                placeholder="Disabled"
                                v-model="materialSeleccion.documento"
                            />
                            <br />
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <h6>1.10 - N° Documento</h6>
                            <br />
                            <vs-input
                                disabled
                                class="inputx w-full"
                                placeholder="Disabled"
                                v-model="materialSeleccion.ndocumento"
                            />
                            <br />
                        </div>
                        <div class="vx-col w-full mt-5">
                            <vs-button
                                class="w-full"
                                color="primary"
                                type="filled"
                                @click="volver"
                                >Volver</vs-button
                            >
                        </div>
                    </div>
                </vx-card>
                <br />
            </div>
        </vs-row>
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
        "v-select": vSelect
    },
    data() {
        return {
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
            selected: [],
            descripcion_seguimiento: "",
            nombre:
                sessionStorage.getItem("nombre") +
                " " +
                sessionStorage.getItem("apellido"),
            run: sessionStorage.getItem("run"),
            materialSeleccion: {
                id: 0,
                id_ubicaciones: "",
                id_servicios: "",
                id_material_ing: "",
                id_material_tipo: "",
                id_cant_esp: "",
                id_material_medida: "",
                material_cantidad: "",
                material_valor: "",
                id_documento: "",
                n_documento: ""
            },
            listadoInventario: [],
            listadoInventarioData: [],

            localVal: process.env.MIX_APP_URL
        };
    },
    methods: {
        handleSelected() {
            console.log(this.selected);
            this.materialSeleccion.id = this.selected.id;
            this.materialSeleccion.id_ubicaciones = this.selected.id_ubicaciones;
            this.materialSeleccion.id_servicios = this.selected.id_servicios;
            this.materialSeleccion.id_material_ing = this.selected.id_material_ing;
            this.materialSeleccion.id_material_tipo = this.selected.id_material_tipo;
            this.materialSeleccion.id_cant_esp = this.selected.id_cant_esp;
            this.materialSeleccion.id_material_medida = this.selected.id_material_medida;
            this.materialSeleccion.material_cantidad = this.selected.material_cantidad;
            this.materialSeleccion.material_valor = this.selected.material_valor;
            this.materialSeleccion.id_documento = this.selected.id_documento;
            this.materialSeleccion.n_documento = this.selected.n_documento;
        },
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
        volver() {
            router.back();
        },

        cargarInventarioDisponible() {
            axios
                .get(this.localVal + "/api/Bodega/GetStock", {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.listadoInventario = res.data;
                    this.listadoInventarioData = res.data;
                });
        }
    },
    created() {
        this.cargarInventarioDisponible();
    }
};
</script>
