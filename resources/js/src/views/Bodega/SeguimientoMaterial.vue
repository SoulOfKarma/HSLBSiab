<template>
    <div>
        <vs-row>
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card>
                    <vs-alert active="true" color="success">
                        Historial Material - Agente:
                        {{ nombre }} - {{ run }}
                    </vs-alert>
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
                                disabled
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
            </div>
            <!-- Lista Seguimiento -->
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="Actualizaciones del Material Seleccionado">
                    <div class="vx-row">
                        <div class="vx-col sm:w-full w-full">
                            <vs-list
                                :key="indextr"
                                v-for="(tr, indextr) in listadoSeguimiento"
                            >
                                <vx-card
                                    :title="
                                        tr.nombre_usuario +
                                            ' ' +
                                            tr.apellido_usuario
                                    "
                                    title-color="primary"
                                >
                                    <p v-html="tr.descripcion_seguimiento">
                                        {{ tr.descripcion_seguimiento }}
                                    </p>
                                </vx-card>
                            </vs-list>
                        </div>
                    </div>
                </vx-card>
            </div>
        </vs-row>
    </div>
</template>
<script>
import axios from "axios";
import router from "../../router";
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import "quill/dist/quill.bubble.css";
import { quillEditor } from "vue-quill-editor";
export default {
    components: {
        quillEditor
    },
    data: () => ({
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
        value2: "",
        localVal: process.env.MIX_APP_URL,
        listadoSeguimiento: [],
        materialSeleccion: {
            id: 0,
            ubicacion: "",
            servicio: "",
            material: "",
            tipo_material: "",
            contenido: "",
            medida: "",
            cantidad: "",
            valor: "",
            documento: "",
            ndocumento: ""
        },
        nombre:
            sessionStorage.getItem("nombre") +
            " " +
            sessionStorage.getItem("apellido"),
        run: sessionStorage.getItem("run")
    }),
    methods: {
        volver() {
            router.back();
        },
        cargarMaterial() {
            let id = this.$route.params.id;
            axios
                .get(this.localVal + `/api/Bodega/TraerMaterial/${id}`, {
                    headers: {
                        Authorization:
                            `Bearer ` + sessionStorage.getItem("token")
                    }
                })
                .then(res => {
                    this.materialSeleccion.id = res.data[0].id;
                    this.materialSeleccion.ubicacion =
                        res.data[0].descripcion_ubicacion;
                    this.materialSeleccion.servicio =
                        res.data[0].descripcion_servicio;
                    this.materialSeleccion.material =
                        res.data[0].descripcion_material;
                    this.materialSeleccion.tipo_material =
                        res.data[0].descripcion_tipo_material;
                    this.materialSeleccion.contenido =
                        res.data[0].descripcion_cantidad_especifica;
                    this.materialSeleccion.medida =
                        res.data[0].descripcion_medidas;
                    this.materialSeleccion.cantidad =
                        res.data[0].material_cantidad;
                    this.materialSeleccion.valor =
                        "$" + res.data[0].material_valor;
                    this.materialSeleccion.documento =
                        res.data[0].descripcion_documento;
                    this.materialSeleccion.ndocumento = res.data[0].n_documento;
                })
                .catch(error => console.log(error));
        },
        cargarSeguimiento() {
            let id = this.$route.params.id;
            axios
                .get(
                    this.localVal + `/api/Bodega/GetSeguimientoMaterial/${id}`,
                    {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    }
                )
                .then(res => {
                    this.listadoSeguimiento = res.data;
                })
                .catch(error => console.log(error));
        }
    },
    created() {
        this.cargarMaterial();
        this.cargarSeguimiento();
    }
};
</script>
