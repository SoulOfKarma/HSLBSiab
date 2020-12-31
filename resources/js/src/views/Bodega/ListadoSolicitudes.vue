<template>
    <div>
        <vx-card title="1. Listado de Tickets">
            <vs-alert active="true" color="success">
                Agente:
                {{ nombre }} - {{ run }}
            </vs-alert>

            <vs-table search :data="listadoTickets" max-items="15" pagination>
                <template slot="thead">
                    <vs-th>N° Solicitud</vs-th>
                    <vs-th>Persona Solicitante</vs-th>
                    <vs-th>Titulo</vs-th>
                    <vs-th>Descripcion</vs-th>
                    <vs-th>Estado</vs-th>
                    <vs-th>Opciones</vs-th>
                </template>

                <template slot-scope="{ data }">
                    <vs-tr :key="indextr" v-for="(tr, indextr) in data">
                        <vs-td :data="data[indextr].id">{{
                            data[indextr].nticket
                        }}</vs-td>

                        <vs-td :data="data[indextr].id_user">{{
                            data[indextr].nombre + " " + data[indextr].apellido
                        }}</vs-td>

                        <vs-td :data="data[indextr].tituloP">{{
                            data[indextr].tituloP
                        }}</vs-td>

                        <vs-td
                            :data="data[indextr].descripcionP"
                            v-html="data[indextr].descripcionP"
                            >{{ data[indextr].descripcionP }}</vs-td
                        >
                        <vs-td :data="data[indextr].descripcionP">{{
                            data[indextr].descripcionEstado
                        }}</vs-td>
                        <vs-td :data="data[indextr].id">
                            <info-icon
                                size="1.5x"
                                class="custom-class"
                                @click="informacionGeneral(data[indextr].id)"
                            ></info-icon
                        ></vs-td>
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
        quillEditor
    },
    data() {
        return {
            nombre:
                sessionStorage.getItem("nombre") +
                " " +
                sessionStorage.getItem("apellido"),
            run: sessionStorage.getItem("run"),
            localVal: process.env.MIX_APP_URL,
            externalVal: process.env.MIX_APP_URL_EXTERNA,
            listadoTickets: []
        };
    },
    methods: {
        informacionGeneral(id) {
            this.$router.push({
                name: "entregaMaterialNSolicitud",
                params: {
                    id: `${id}`
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
                    this.listadoTickets = res.data;
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
            this.cargarSolicitudesExternas();
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
