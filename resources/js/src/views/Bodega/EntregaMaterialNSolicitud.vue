<template>
    <div>
        <vs-row>
            <div
                class="router-header flex flex-wrap items-center mb-8"
                style="margin-left:10px;"
            >
                <div
                    class="content-area__heading pr-4 border-0 md:border-r border-solid border-grey-light"
                >
                    <h2 class="mb-1">Entrega de Material Sin Solicitud</h2>
                </div>
                <div class="vx-breadcrumb ml-4 md:block hidden">
                    <div
                        class="content-area__heading pr-4 border-0 md:border-r border-solid border-grey-light"
                    >
                        <h3 class="mb-1">
                            Agente:
                            <p>{{ nombre }} - {{ run }}</p>
                        </h3>
                    </div>
                </div>
            </div>
            <vs-alert
                color="primary"
                icon="new_releases"
                active="true"
                style="margin-bottom: 10px;"
            >
                <p>Recuerda que todos los campos son obligatorios!</p>
            </vs-alert>
            <!-- Ubicacion -->
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="1. Lugar del problema">
                    <div class="vx-row mb-12"></div>
                </vx-card>
            </div>
            <!-- Personal -->
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="2. Asignar Supervisor y Tecnico">
                    <div class="vx-row mb-12"></div>
                </vx-card>
            </div>
            <!-- Hora y Fecha -->
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="3. Asignar Hora y Fecha">
                    <div class="vx-row mb-12">
                        <div class="vx-col w-1/2 mt-5"></div>
                    </div>
                </vx-card>
            </div>
            <!-- Informacion del problema -->
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="4. Problema a Resolver">
                    <div class="vx-row mb-12">
                        <div class="vx-col w-full mt-5"></div>
                    </div>
                </vx-card>
            </div>
            <!-- Enviar o Limpiar Formulario -->
            <div class="vx-col md:w-1/1 w-full mb-base">
                <div class="vx-row">
                    <div class="vx-col sm:w-2/3 w-full ml-auto"></div>
                </div>
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
            run: sessionStorage.getItem("run")
        };
    }
};
</script>
