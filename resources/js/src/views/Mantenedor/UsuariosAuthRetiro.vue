<template>
    <div>
        <vx-card title="Usuarios">
            <div>
                <vs-button
                    color="primary"
                    type="filled"
                    @click="popAuthUsuarios"
                    >Agregar Nuevo Usuario</vs-button
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
                                <plus-circle-icon
                                    content="Modificar Usuario Autorizado"
                                    v-tippy
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        popModificarAuthUsuarios(
                                            props.row.id,
                                            props.row.RUN,
                                            props.row.NOMBRES,
                                            props.row.APELLIDOS,
                                            props.row.FECINI,
                                            props.row.idEstado,
                                            props.row.idServicio
                                        )
                                    "
                                ></plus-circle-icon>
                                <plus-circle-icon
                                    content="Abrir Documento"
                                    v-tippy
                                    size="1.5x"
                                    class="custom-class"
                                    @click="
                                        abrirDocumento(
                                            props.row.nombreDocAutogenerado
                                        )
                                    "
                                ></plus-circle-icon>
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
                classContent="Usuarios"
                title="Agregar Usuario"
                :active.sync="popUpUsuario"
            >
                <div class="vx-col md:w-1/1 w-full mb-base">
                    <vx-card title="">
                        <div class="vx-row ">
                            <div class="vx-col w-full mt-5">
                                <h6>Rut Usuario</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    placeholder="Placeholder"
                                    v-model="rutUsuario"
                                    formatear_run
                                />
                                <span
                                    style="font-size: 10px; color: red; margin-left: 10px;"
                                    v-if="val_run"
                                    >Run incorrecto</span
                                >
                            </div>
                        </div>
                        <div class="vx-row">
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Nombre</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    placeholder="Placeholder"
                                    v-model="nombreUsuario"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Apellido</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    placeholder="Placeholder"
                                    v-model="apellidoUsuario"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Servicio</h6>
                                <br />
                                <v-select
                                    taggable
                                    v-model="seleccionServicio"
                                    placeholder="Servicio"
                                    class="w-full select-large"
                                    label="descripcionServicio"
                                    :options="listadoServicios"
                                ></v-select>
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Estado</h6>
                                <br />
                                <v-select
                                    taggable
                                    v-model="seleccionEstado"
                                    placeholder="Estado"
                                    class="w-full select-large"
                                    label="descripcionEstado"
                                    :options="listadoAuthEstados"
                                ></v-select>
                            </div>
                            <div class="vx-col w-full mt-5">
                                <h6>Fecha Inicio</h6>
                                <br />

                                <flat-pickr
                                    :config="configFromdateTimePicker"
                                    v-model="fechaInicio"
                                    placeholder="Fecha Inicio"
                                    @on-change="onFromChange"
                                    class="w-full "
                                />
                            </div>
                        </div>
                        <br />
                        <div class="vx-col md:w-1/1 w-full mb-base">
                            <vx-card title="Adjuntar Documento">
                                <div class="vx-row mb-12">
                                    <div class="vx-col w-1/8 mt-5">
                                        <vs-input
                                            type="file"
                                            id="archivo"
                                            @change="getImage"
                                            class="form-control w-full"
                                        />
                                    </div>
                                    <div class="vx-col w-1/2 mt-5">
                                        <h5 class="w-full ">
                                            <p class="pt-4 text-justify">
                                                {{ nombrearchivo }}
                                            </p>
                                        </h5>
                                    </div>
                                </div>
                            </vx-card>
                        </div>
                        <div class="vx-row w-full md-5">
                            <div class="vx-col w-1/2 ">
                                <vs-button
                                    @click="popUpUsuario = false"
                                    color="primary"
                                    type="filled"
                                    class="w-full m-1"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/2 ">
                                <vs-button
                                    @click="AgregarAuthUsuario"
                                    color="danger"
                                    type="filled"
                                    class="w-full m-1"
                                    >Agregar Usuario</vs-button
                                >
                            </div>
                        </div>
                    </vx-card>
                    <div class="vx-row"></div>
                </div>
            </vs-popup>
            <vs-popup
                classContent="Usuarios"
                title="Modificar Usuario"
                :active.sync="popUpUsuarioMod"
            >
                <div class="vx-col md:w-1/1 w-full mb-base">
                    <vx-card title="">
                        <div class="vx-row ">
                            <div class="vx-col w-full mt-5">
                                <h6>Rut Usuario</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    placeholder="Placeholder"
                                    v-model="rutUsuario"
                                    formatear_run
                                />
                                <span
                                    style="font-size: 10px; color: red; margin-left: 10px;"
                                    v-if="val_run"
                                    >Run incorrecto</span
                                >
                            </div>
                        </div>
                        <div class="vx-row">
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Nombre</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    placeholder="Placeholder"
                                    v-model="nombreUsuario"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Apellido</h6>
                                <br />
                                <vs-input
                                    class="inputx w-full mb-6 "
                                    placeholder="Placeholder"
                                    v-model="apellidoUsuario"
                                />
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Servicio</h6>
                                <br />
                                <v-select
                                    taggable
                                    v-model="seleccionServicio"
                                    placeholder="Servicio"
                                    class="w-full select-large"
                                    label="descripcionServicio"
                                    :options="listadoServicios"
                                ></v-select>
                            </div>
                            <div class="vx-col w-1/2 mt-5">
                                <h6>Estado</h6>
                                <br />
                                <v-select
                                    taggable
                                    v-model="seleccionEstado"
                                    placeholder="Estado"
                                    class="w-full select-large"
                                    label="descripcionEstado"
                                    :options="listadoAuthEstados"
                                ></v-select>
                            </div>
                            <div class="vx-col w-full mt-5">
                                <h6>Fecha Inicio</h6>
                                <br />

                                <flat-pickr
                                    :config="configFromdateTimePicker"
                                    v-model="fechaInicio"
                                    placeholder="Fecha Inicio"
                                    @on-change="onFromChange"
                                    class="w-full "
                                />
                            </div>
                        </div>
                        <br />
                        <div class="vx-col md:w-1/1 w-full mb-base">
                            <vx-card title="Adjuntar Documento">
                                <div class="vx-row mb-12">
                                    <div class="vx-col w-1/8 mt-5">
                                        <vs-input
                                            type="file"
                                            id="archivo"
                                            @change="getImage"
                                            class="form-control w-full"
                                        />
                                    </div>
                                    <div class="vx-col w-1/2 mt-5">
                                        <h5 class="w-full ">
                                            <p class="pt-4 text-justify">
                                                {{ nombrearchivo }}
                                            </p>
                                        </h5>
                                    </div>
                                </div>
                            </vx-card>
                        </div>
                        <div class="vx-row w-full md-5">
                            <div class="vx-col w-1/2 ">
                                <vs-button
                                    @click="popUpUsuarioMod = false"
                                    color="primary"
                                    type="filled"
                                    class="w-full m-1"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/2 ">
                                <vs-button
                                    @click="ModificarAuthUsuario"
                                    color="danger"
                                    type="filled"
                                    class="w-full m-1"
                                    >Modificar Usuario</vs-button
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
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
import moment from "moment";
import axios from "axios";
import vSelect from "vue-select";
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import "quill/dist/quill.bubble.css";
import { quillEditor } from "vue-quill-editor";
import "vue-good-table/dist/vue-good-table.css";
import { VueGoodTable } from "vue-good-table";
import { validate, clean, format } from "rut.js";
import { PlusCircleIcon } from "vue-feather-icons";
import Vue from "vue";
import VueTippy, { TippyComponent } from "vue-tippy";
Vue.use(VueTippy);
Vue.component("tippy", TippyComponent);

export default {
    components: {
        VueGoodTable,
        "v-select": vSelect,
        quillEditor,
        PlusCircleIcon,
        flatPickr
    },
    data() {
        return {
            //Datos Locales - Variables de Entorno
            localVal: process.env.MIX_APP_URL,
            localDoc: process.env.MIX_APP_URL_DOCUMENTOS,
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
            popUpUsuario: false,
            popUpUsuarioMod: false,
            popUpUsuarioElim: false,
            rutUsuario: "",
            nombreUsuario: "",
            apellidoUsuario: "",
            image: null,
            nombrearchivo: "",
            idServicio: 0,
            idEstado: 0,
            fechaInicio: null,
            val_run: false,
            val_doc: 0,
            idMod: 0,
            seleccionServicio: {
                id: 0,
                descripcionServicio: ""
            },
            seleccionEstado: {
                id: 0,
                descripcionEstado: ""
            },
            //Datos Fechas
            configFromdateTimePicker: {
                minDate: null,
                maxDate: null,
                locale: {
                    firstDayOfWeek: 1,
                    weekdays: {
                        shorthand: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                        longhand: [
                            "Domingo",
                            "Lunes",
                            "Martes",
                            "Miércoles",
                            "Jueves",
                            "Viernes",
                            "Sábado"
                        ]
                    },
                    months: {
                        shorthand: [
                            "Ene",
                            "Feb",
                            "Mar",
                            "Abr",
                            "May",
                            "Jun",
                            "Jul",
                            "Ago",
                            "Sep",
                            "Оct",
                            "Nov",
                            "Dic"
                        ],
                        longhand: [
                            "Enero",
                            "Febrero",
                            "Мarzo",
                            "Abril",
                            "Mayo",
                            "Junio",
                            "Julio",
                            "Agosto",
                            "Septiembre",
                            "Octubre",
                            "Noviembre",
                            "Diciembre"
                        ]
                    }
                }
            },
            configTodateTimePicker: {
                minDate: null,
                locale: {
                    firstDayOfWeek: 1,
                    weekdays: {
                        shorthand: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                        longhand: [
                            "Domingo",
                            "Lunes",
                            "Martes",
                            "Miércoles",
                            "Jueves",
                            "Viernes",
                            "Sábado"
                        ]
                    },
                    months: {
                        shorthand: [
                            "Ene",
                            "Feb",
                            "Mar",
                            "Abr",
                            "May",
                            "Jun",
                            "Jul",
                            "Ago",
                            "Sep",
                            "Оct",
                            "Nov",
                            "Dic"
                        ],
                        longhand: [
                            "Enero",
                            "Febrero",
                            "Мarzo",
                            "Abril",
                            "Mayo",
                            "Junio",
                            "Julio",
                            "Agosto",
                            "Septiembre",
                            "Octubre",
                            "Noviembre",
                            "Diciembre"
                        ]
                    }
                }
            },
            configdateTimePicker: {
                enableTime: false,
                //enableSeconds: true,
                noCalendar: true,
                time_24hr: true,
                dateFormat: "H:i"
            },
            configdateToTimePicker: {
                enableTime: false,
                noCalendar: true,
                time_24hr: true,
                dateFormat: "H:i"
            },
            //Template Columnas Listado Proveedor
            columns: [
                {
                    label: "Run Usuario",
                    field: "RUN",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Nombre",
                    field: "NOMBRES",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Apellido",
                    field: "APELLIDOS",
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
                    label: "Fecha Inicio",
                    field: "FECINI",
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
                    label: "Opciones",
                    field: "action"
                }
            ],
            //Datos Listados
            listadoServicios: [],
            listadoAuthEstados: [],
            rows: []
        };
    },
    methods: {
        //Metodos Reusables
        onFromChange(selectedDates, dateStr, instance) {
            this.$set(this.configTodateTimePicker, "minDate", dateStr);
        },
        openLoadingColor() {
            this.$vs.loading({ color: this.colorLoading });
            setTimeout(() => {
                this.$vs.loading.close();
            }, 1000);
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
        formatear_run() {
            if (this.rutUsuario == "" || this.rutUsuario == null) {
                //console.log("Sin Rut");
                this.val_run = false;
            } else {
                this.rutUsuario = format(this.rutUsuario);
                this.val_run = !validate(this.rutUsuario);
            }
        },
        limpiarCampos() {
            try {
                this.rutUsuario = "";
                this.nombreUsuario = "";
                this.apellidoUsuario = "";
                this.fechaInicio = null;
                this.seleccionEstado = { id: 0, descripcionEstado: "" };
                this.seleccionServicio = { id: 0, descripcionServicio: "" };
                this.val_doc = 0;
                this.idMod = 0;
            } catch (error) {
                console.log(error);
            }
        },
        //PopUp
        popAuthUsuarios() {
            try {
                this.limpiarCampos();
                this.popUpUsuario = true;
            } catch (error) {
                console.log(error);
            }
        },
        popModificarAuthUsuarios(id, rut, nom, ape, fechaI, idEst, idSer) {
            try {
                this.limpiarCampos();
                this.idMod = id;
                this.rutUsuario = rut;
                this.nombreUsuario = nom;
                this.apellidoUsuario = ape;
                this.fechaInicio = fechaI;
                let idEstado = idEst;
                let idServicio = idSer;

                let c = this.listadoServicios;
                let b = [];
                c.forEach((value, index) => {
                    if (idServicio == value.id) {
                        this.seleccionServicio = {
                            id: value.id,
                            descripcionServicio: value.descripcionServicio
                        };
                    }
                });

                c = [];
                c = this.listadoAuthEstados;

                c.forEach((value, index) => {
                    if (idEstado == value.id) {
                        this.seleccionEstado = {
                            id: value.id,
                            descripcionEstado: value.descripcionEstado
                        };
                    }
                });

                this.popUpUsuarioMod = true;
            } catch (error) {
                console.log(error);
            }
        },
        popEliminarAuthUsuarios() {
            try {
                this.popUpUsuarioElim = true;
            } catch (error) {
                console.log(error);
            }
        },
        //Metodos CRUD
        TraerServicio() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetServicios", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listadoServicios = res.data;
                        if (this.listadoServicios.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos de los servicios correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        TraerEstado() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetAuthEstado", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listadoAuthEstados = res.data;
                        if (this.listadoAuthEstados.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos de los servicios correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        TraerAuthUsuario() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetAuthUsuario", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.rows = res.data;
                        if (this.rows.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos de los usuarios autorizados correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        AgregarAuthUsuario() {
            try {
                let data = {
                    RUN: this.rutUsuario,
                    NOMBRES: this.nombreUsuario,
                    APELLIDOS: this.apellidoUsuario,
                    FECINI: this.fechaInicio,
                    FECFIN: null,
                    idEstado: this.seleccionEstado.id,
                    idServicio: this.seleccionServicio.id
                };

                const dat = data;

                axios
                    .post(
                        this.localVal + "/api/Mantenedor/PostAuthUsuario",
                        dat,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.idMod = res.data;
                        if (this.idMod > 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Completado",
                                text:
                                    "Usuario Autorizado Ingresado Correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.popUpUsuario = false;
                            if (this.val_doc == 1) {
                                this.uploadImage();
                            } else {
                                this.TraerAuthUsuario();
                                this.limpiarCampos();
                            }
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No fue posible registrar el usuario,intentelo nuevamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        ModificarAuthUsuario() {
            try {
                let data = {
                    id: this.idMod,
                    RUN: this.rutUsuario,
                    NOMBRES: this.nombreUsuario,
                    APELLIDOS: this.apellidoUsuario,
                    FECINI: this.fechaInicio,
                    FECFIN: null,
                    idEstado: this.seleccionEstado.id,
                    idServicio: this.seleccionServicio.id
                };

                const dat = data;

                axios
                    .post(
                        this.localVal + "/api/Mantenedor/PutAuthUsuario",
                        dat,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        const solicitudServer = res.data;
                        if (solicitudServer == true) {
                            if (this.val_doc == 1) {
                                this.uploadImageMod();
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Completado",
                                    text:
                                        "Usuario Autorizado Modificado Correctamente",
                                    color: "success",
                                    position: "top-right"
                                });
                            } else {
                                this.TraerAuthUsuario();
                                this.limpiarCampos();
                                this.popUpUsuarioMod = false;
                            }
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No fue posible registrar el usuario,intentelo nuevamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        getImage(event) {
            //Asignamos la imagen a  nuestra data
            this.image = event.target.files[0];
            this.nombrearchivo = this.image.name;
            this.val_doc = 1;
        },
        uploadImage() {
            //Creamos el formData

            var data = new FormData();
            //Añadimos la imagen seleccionada
            data.append("avatar", this.image);
            data.append("id", this.idMod);
            data.append("nombreDocOriginal", this.nombrearchivo);

            axios
                .post(
                    this.localVal + "/api/Mantenedor/PostDocumentoAuthUsuario",
                    data,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data",
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    }
                )
                .then(response => {
                    let resp = response.data;
                    if (resp == true) {
                        this.$vs.notify({
                            title: "Documento Guardado ",
                            text:
                                "Podra Visualizarlo en el listado los usuarios autorizados ",
                            color: "success",
                            position: "top-right"
                        });
                        this.popUpUsuario = false;
                        this.limpiarCampos();
                        this.TraerAuthUsuario();
                    } else {
                        this.$vs.notify({
                            title: "Error al subir el documento ",
                            text:
                                "Intente nuevamente con el formato PDF o alguna Imagen ",
                            color: "danger",
                            position: "top-right"
                        });
                    }
                })
                .catch(error => {
                    if (error.response.status === 401) {
                        this.$vs.notify({
                            title: "Token Invalido ",
                            text: "Debe iniciar sesion nuevamente",
                            color: "danger",
                            position: "top-right",
                            time: 3000
                        });
                    }
                });
        },
        uploadImageMod() {
            //Creamos el formData

            var data = new FormData();
            //Añadimos la imagen seleccionada
            data.append("avatar", this.image);
            data.append("id", this.idMod);
            data.append("nombreDocOriginal", this.nombrearchivo);

            axios
                .post(
                    this.localVal + "/api/Mantenedor/PutDocumentoAuthUsuario",
                    data,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data",
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    }
                )
                .then(response => {
                    let resp = response.data;
                    if (resp == true) {
                        this.$vs.notify({
                            title: "Documento Modificado ",
                            text:
                                "Podra Visualizarlo en el listado los usuarios autorizados ",
                            color: "success",
                            position: "top-right"
                        });
                        this.popUpUsuarioMod = false;
                        this.limpiarCampos();
                        this.TraerAuthUsuario();
                    } else {
                        this.$vs.notify({
                            title: "Error al subir el documento ",
                            text:
                                "Intente nuevamente con el formato PDF o alguna Imagen ",
                            color: "danger",
                            position: "top-right"
                        });
                    }
                })
                .catch(error => {
                    if (error.response.status === 401) {
                        this.$vs.notify({
                            title: "Token Invalido ",
                            text: "Debe iniciar sesion nuevamente",
                            color: "danger",
                            position: "top-right",
                            time: 3000
                        });
                    }
                });
        },
        abrirDocumento(doc) {
            try {
                const url = this.localDoc + "/" + doc;
                window.open(url, "_blank");
            } catch (error) {
                console.log(error);
            }
        }
    },
    beforeMount() {
        this.TraerServicio();
        this.TraerEstado();
        this.TraerAuthUsuario();
        this.openLoadingColor();
    }
};
</script>
<style lang="stylus">
.con-vs-popup .vs-popup {
  width: 1000px;
}
</style>
