<template>
    <div>
        <vx-card title="Servicio">
            <div class="vx-row">
                <div class="vx-col w-1/5">
                    <vs-button
                        class="w-full"
                        color="primary"
                        type="filled"
                        @click="popJerarquia"
                        >Agregar o Modificar Jerarquia</vs-button
                    >
                </div>
                <div class="vx-col w-1/5">
                    <vs-button
                        class="w-full"
                        color="primary"
                        type="filled"
                        @click="popSubJerarquia"
                        >Agregar o Modificar Sub-Jerarquia</vs-button
                    >
                </div>
                <div class="vx-col w-1/5">
                    <vs-button
                        class="w-full"
                        color="primary"
                        type="filled"
                        @click="popDepartamento"
                        >Agregar o Modificar Departamento</vs-button
                    >
                </div>
                <div class="vx-col w-1/5">
                    <vs-button
                        class="w-full"
                        color="primary"
                        type="filled"
                        @click="popUnidad"
                        >Agregar o Modificar Unidad</vs-button
                    >
                </div>
                <div class="vx-col w-1/5">
                    <vs-button
                        class="w-full"
                        color="primary"
                        type="filled"
                        @click="popSubUnidad"
                        >Agregar o Modificar Sub-Unidad</vs-button
                    >
                </div>
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
            <!--             <br />
            <div>
                <vx-card>
                    <div class="vx-col w-full md-5">
                        <hot-table
                            :settings="settings"
                            :data="data"
                            :rowHeaders="true"
                            :colHeaders="true"
                        ></hot-table>
                    </div>
                </vx-card>
            </div> -->
            <!-- Jerarquia -->
            <vs-popup
                classContent="AgregarJerarquia"
                title="Jerarquia"
                :active.sync="popUpJerarquia"
            >
                <div class="vx-row w-full">
                    <div class="vx-col w-1/2 mt-5">
                        <vx-card title="Agregar Jerarquia">
                            <div class="vx-col w-full">
                                <h6>Ingrese Descripcion Jerarquica</h6>
                                <vs-input
                                    class="inputx w-full  "
                                    v-model="descripcionJerarquia"
                                />
                            </div>
                            <br />
                            <div class="vx-row w-full">
                                <div class="vx-col w-1/2">
                                    <vs-button
                                        @click="popUpJerarquia = false"
                                        color="primary"
                                        type="filled"
                                        class="w-full"
                                        >Volver</vs-button
                                    >
                                </div>
                                <div class="vx-col w-1/2">
                                    <vs-button
                                        @click="AgregarJerarquia"
                                        color="success"
                                        type="filled"
                                        class="w-full"
                                        >Agregar Jerarquia</vs-button
                                    >
                                </div>
                            </div>
                        </vx-card>
                    </div>
                    <div class="vx-col w-1/2 mt-5">
                        <vx-card title="Modificar Jerarquia">
                            <div class="vx-row">
                                <div class="vx-col w-1/2">
                                    <h6>Seleccione Jerarquia</h6>
                                    <v-select
                                        v-model="seleccionSF1Mod"
                                        placeholder="Ej. Direccion"
                                        class="w-full select-large"
                                        label="descripcionSF1"
                                        :options="listadoJerarquia"
                                        @input="cargaJerarquia"
                                    ></v-select>
                                </div>
                                <div class="vx-col w-1/2">
                                    <h6>.</h6>
                                    <vs-input
                                        class="inputx w-full"
                                        v-model="descripcionJerarquiaMod"
                                    />
                                </div>
                            </div>
                            <br />
                            <div class="vx-row w-full">
                                <div class="vx-col w-1/2">
                                    <vs-button
                                        @click="popUpJerarquia = false"
                                        color="primary"
                                        type="filled"
                                        class="w-full"
                                        >Volver</vs-button
                                    >
                                </div>
                                <div class="vx-col w-1/2">
                                    <vs-button
                                        @click="ModificarJerarquia"
                                        color="success"
                                        type="filled"
                                        class="w-full"
                                        >Modificar Jerarquia</vs-button
                                    >
                                </div>
                            </div>
                        </vx-card>
                    </div>
                </div>
            </vs-popup>
            <!-- Sub-Jerarquia -->
            <vs-popup
                classContent="AgregarSubJerarquia"
                title="Sub-Jerarquia"
                :active.sync="popUpSubJerarquia"
            >
                <div class="vx-row w-full">
                    <div class="vx-col w-1/2 mt-5">
                        <vx-card title="Agregar Sub-Jerarquia">
                            <div class="vx-row w-full">
                                <div class="vx-col w-full">
                                    <h6>Seleccione Jerarquia</h6>
                                    <v-select
                                        v-model="seleccionSF1"
                                        placeholder="Ej. Direccion"
                                        class="w-full select-large"
                                        label="descripcionSF1"
                                        :options="listadoJerarquia"
                                        @input="cargaJerarquia"
                                    ></v-select>
                                </div>
                            </div>
                            <br />
                            <div class="vx-row w-full">
                                <div class="vx-col w-full">
                                    <h6>Ingrese Descripcion Sub-Jerarquica</h6>
                                    <vs-input
                                        class="inputx w-full  "
                                        v-model="descripcionSubJerarquia"
                                    />
                                </div>
                            </div>
                            <br />
                            <div class="vx-row w-full">
                                <div class="vx-col w-1/2">
                                    <vs-button
                                        @click="popUpSubJerarquia = false"
                                        color="primary"
                                        type="filled"
                                        class="w-full"
                                        >Volver</vs-button
                                    >
                                </div>
                                <div class="vx-col w-1/2">
                                    <vs-button
                                        @click="AgregarSubJerarquia"
                                        color="success"
                                        type="filled"
                                        class="w-full"
                                        >Agregar Sub-Jerarquia</vs-button
                                    >
                                </div>
                            </div>
                        </vx-card>
                    </div>
                    <div class="vx-col w-1/2 mt-5">
                        <vx-card title="Modificar Sub-Jerarquia">
                            <div class="vx-row w-full">
                                <div class="vx-col w-full">
                                    <h6>Seleccione Jerarquia</h6>
                                    <v-select
                                        v-model="seleccionSF1Mod"
                                        placeholder="Ej. Direccion"
                                        class="w-full select-large"
                                        label="descripcionSF1"
                                        :options="listadoJerarquia"
                                        @input="CargaListadoSubJerarquiaMod"
                                    ></v-select>
                                </div>
                            </div>
                            <br />
                            <div class="vx-row">
                                <div class="vx-col w-1/2">
                                    <h6>Seleccione Sub-Jerarquia</h6>
                                    <v-select
                                        v-model="seleccionSF2Mod"
                                        placeholder="Ej. Direccion"
                                        class="w-full select-large"
                                        label="descripcionSF2"
                                        :options="listadoSubJerarquia"
                                        @input="cargaSubJerarquia"
                                    ></v-select>
                                </div>
                                <div class="vx-col w-1/2">
                                    <h6>.</h6>
                                    <vs-input
                                        class="inputx w-full  "
                                        v-model="descripcionSubJerarquiaMod"
                                    />
                                </div>
                            </div>
                            <br />
                            <div class="vx-row w-full">
                                <div class="vx-col w-1/2">
                                    <vs-button
                                        @click="popUpSubJerarquia = false"
                                        color="primary"
                                        type="filled"
                                        class="w-full"
                                        >Volver</vs-button
                                    >
                                </div>
                                <div class="vx-col w-1/2">
                                    <vs-button
                                        @click="ModificarSubJerarquia"
                                        color="success"
                                        type="filled"
                                        class="w-full"
                                        >Modificar Sub-Jerarquia</vs-button
                                    >
                                </div>
                            </div>
                        </vx-card>
                    </div>
                </div>
            </vs-popup>
            <!-- Departamento -->
            <vs-popup
                classContent="AgregarDepartamento"
                title="Departamento"
                :active.sync="popUpDepartamento"
            >
                <div class="vx-row w-full">
                    <div class="vx-col w-1/2 mt-5">
                        <vx-card title="Agregar Departamento">
                            <div class="vx-row w-full">
                                <div class="vx-col w-full">
                                    <h6>Seleccione Jerarquia</h6>
                                    <v-select
                                        v-model="seleccionSF1"
                                        placeholder="Ej. Direccion"
                                        class="w-full select-large"
                                        label="descripcionSF1"
                                        :options="listadoJerarquia"
                                        @input="CargaListadoSubJerarquia"
                                    ></v-select>
                                </div>
                            </div>
                            <br />
                            <div class="vx-row w-full">
                                <div class="vx-col w-full">
                                    <h6>Seleccione Sub-Jerarquia</h6>
                                    <v-select
                                        v-model="seleccionSF2"
                                        placeholder="Ej. Direccion"
                                        class="w-full select-large"
                                        label="descripcionSF2"
                                        :options="listadoSubJerarquia"
                                    ></v-select>
                                </div>
                            </div>
                            <br />
                            <div class="vx-row w-full">
                                <div class="vx-col w-1/2">
                                    <h6>Ingrese Descripcion Departamento</h6>
                                    <vs-input
                                        class="inputx w-full  "
                                        v-model="descripcionDepartamento"
                                    />
                                </div>
                                <br />
                                <div class="vx-col w-1/2">
                                    <h6>
                                        Marque solo si es un servicio
                                        despachable
                                    </h6>
                                    <br />

                                    <vs-checkbox
                                        class="px-32"
                                        v-model="VisualizarDepartamento"
                                    ></vs-checkbox>
                                </div>
                            </div>
                            <br />
                            <div class="vx-row w-full">
                                <div class="vx-col w-1/2">
                                    <vs-button
                                        @clickDepartamento="
                                            popUpDepartamento = false
                                        "
                                        color="primary"
                                        type="filled"
                                        class="w-full"
                                        >Volver</vs-button
                                    >
                                </div>
                                <div class="vx-col w-1/2">
                                    <vs-button
                                        @click="AgregarDepartamento"
                                        color="success"
                                        type="filled"
                                        class="w-full"
                                        >Agregar Departamento</vs-button
                                    >
                                </div>
                            </div>
                        </vx-card>
                    </div>
                    <div class="vx-col w-1/2 mt-5">
                        <vx-card title="Modificar Departamento">
                            <div class="vx-row w-full">
                                <div class="vx-col w-full">
                                    <h6>Seleccione Jerarquia</h6>
                                    <v-select
                                        v-model="seleccionSF1Mod"
                                        placeholder="Ej. Direccion"
                                        class="w-full select-large"
                                        label="descripcionSF1"
                                        :options="listadoJerarquia"
                                        @input="CargaListadoSubJerarquiaMod"
                                    ></v-select>
                                </div>
                            </div>
                            <br />
                            <div class="vx-row w-full">
                                <div class="vx-col w-full">
                                    <h6>Seleccione Sub-Jerarquia</h6>
                                    <v-select
                                        v-model="seleccionSF2Mod"
                                        placeholder="Ej. Direccion"
                                        class="w-full select-large"
                                        label="descripcionSF2"
                                        :options="listadoSubJerarquia"
                                        @input="CargaListadoDepartamentoMod"
                                    ></v-select>
                                </div>
                            </div>
                            <br />
                            <div class="vx-row">
                                <div class="vx-col w-full">
                                    <h6>Seleccione Departamento</h6>
                                    <v-select
                                        v-model="seleccionSF3Mod"
                                        placeholder="Ej. Direccion"
                                        class="w-full select-large"
                                        label="descripcionSF3"
                                        :options="listadoDepartamento"
                                        @input="cargaDepartamento"
                                    ></v-select>
                                </div>
                            </div>
                            <br />
                            <div class="vx-row">
                                <div class="vx-col w-1/2">
                                    <h6>Ingrese Modificacion Departamento</h6>
                                    <vs-input
                                        class="inputx w-full  "
                                        v-model="descripcionDepartamentoMod"
                                    />
                                </div>
                                <div class="vx-col w-1/2">
                                    <h6>
                                        Marque solo si es un servicio
                                        despachable
                                    </h6>
                                    <br />

                                    <vs-checkbox
                                        class="px-32"
                                        v-model="VisualizarDepartamentoMod"
                                    ></vs-checkbox>
                                </div>
                            </div>
                            <br />
                            <div class="vx-row w-full">
                                <div class="vx-col w-1/2">
                                    <vs-button
                                        @click="popUpDepartamento = false"
                                        color="primary"
                                        type="filled"
                                        class="w-full"
                                        >Volver</vs-button
                                    >
                                </div>
                                <div class="vx-col w-1/2">
                                    <vs-button
                                        @click="ModificarDepartamento"
                                        color="success"
                                        type="filled"
                                        class="w-full"
                                        >Modificar Departamento</vs-button
                                    >
                                </div>
                            </div>
                        </vx-card>
                    </div>
                </div>
            </vs-popup>
            <!-- Unidad -->
            <vs-popup
                classContent="AgregarUnidad"
                title="Unidad"
                :active.sync="popUpUnidad"
            >
                <div class="vx-row w-full">
                    <div class="vx-col w-1/2 mt-5">
                        <vx-card title="Agregar Unidad">
                            <div class="vx-row w-full">
                                <div class="vx-col w-full">
                                    <h6>Seleccione Jerarquia</h6>
                                    <v-select
                                        v-model="seleccionSF1"
                                        placeholder="Ej. Direccion"
                                        class="w-full select-large"
                                        label="descripcionSF1"
                                        :options="listadoJerarquia"
                                        @input="CargaListadoSubJerarquia"
                                    ></v-select>
                                </div>
                            </div>
                            <br />
                            <div class="vx-row w-full">
                                <div class="vx-col w-full">
                                    <h6>Seleccione Sub-Jerarquia</h6>
                                    <v-select
                                        v-model="seleccionSF2"
                                        placeholder="Ej. Direccion"
                                        class="w-full select-large"
                                        label="descripcionSF2"
                                        :options="listadoSubJerarquia"
                                        @input="CargaListadoDepartamento"
                                    ></v-select>
                                </div>
                            </div>
                            <br />
                            <div class="vx-row w-full">
                                <div class="vx-col w-full">
                                    <h6>Seleccione Departamento</h6>
                                    <v-select
                                        v-model="seleccionSF3"
                                        placeholder="Ej. Direccion"
                                        class="w-full select-large"
                                        label="descripcionSF3"
                                        :options="listadoDepartamento"
                                    ></v-select>
                                </div>
                            </div>
                            <br />
                            <div class="vx-row w-full">
                                <div class="vx-col w-1/2">
                                    <h6>Ingrese Descripcion Unidad</h6>
                                    <vs-input
                                        class="inputx w-full  "
                                        v-model="descripcionUnidad"
                                    />
                                </div>
                                <br />
                                <div class="vx-col w-1/2">
                                    <h6>
                                        Marque solo si es un servicio
                                        despachable
                                    </h6>
                                    <br />

                                    <vs-checkbox
                                        class="px-32"
                                        v-model="VisualizarUnidad"
                                    ></vs-checkbox>
                                </div>
                            </div>
                            <br />
                            <div class="vx-row w-full">
                                <div class="vx-col w-1/2">
                                    <vs-button
                                        @click="popUpUnidad = false"
                                        color="primary"
                                        type="filled"
                                        class="w-full"
                                        >Volver</vs-button
                                    >
                                </div>
                                <div class="vx-col w-1/2">
                                    <vs-button
                                        @click="AgregarUnidad"
                                        color="success"
                                        type="filled"
                                        class="w-full"
                                        >Agregar Unidad</vs-button
                                    >
                                </div>
                            </div>
                        </vx-card>
                    </div>
                    <div class="vx-col w-1/2 mt-5">
                        <vx-card title="Modificar Unidad">
                            <div class="vx-row w-full">
                                <div class="vx-col w-full">
                                    <h6>Seleccione Jerarquia</h6>
                                    <v-select
                                        v-model="seleccionSF1Mod"
                                        placeholder="Ej. Direccion"
                                        class="w-full select-large"
                                        label="descripcionSF1"
                                        :options="listadoJerarquia"
                                        @input="CargaListadoSubJerarquiaMod"
                                    ></v-select>
                                </div>
                            </div>
                            <br />
                            <div class="vx-row w-full">
                                <div class="vx-col w-full">
                                    <h6>Seleccione Sub-Jerarquia</h6>
                                    <v-select
                                        v-model="seleccionSF2Mod"
                                        placeholder="Ej. Direccion"
                                        class="w-full select-large"
                                        label="descripcionSF2"
                                        :options="listadoSubJerarquia"
                                        @input="CargaListadoDepartamentoMod"
                                    ></v-select>
                                </div>
                            </div>
                            <br />
                            <div class="vx-row w-full">
                                <div class="vx-col w-full">
                                    <h6>Seleccione Departamento</h6>
                                    <v-select
                                        v-model="seleccionSF3Mod"
                                        placeholder="Ej. Direccion"
                                        class="w-full select-large"
                                        label="descripcionSF3"
                                        :options="listadoDepartamento"
                                        @input="CargaListadoUnidadMod"
                                    ></v-select>
                                </div>
                            </div>
                            <br />
                            <div class="vx-row">
                                <div class="vx-col w-full">
                                    <h6>Seleccione Unidad</h6>
                                    <v-select
                                        v-model="seleccionSF4Mod"
                                        placeholder="Ej. Direccion"
                                        class="w-full select-large"
                                        label="descripcionSF4"
                                        :options="listadoUnidad"
                                        @input="cargaUnidad"
                                    ></v-select>
                                </div>
                            </div>
                            <br />
                            <div class="vx-row">
                                <div class="vx-col w-1/2">
                                    <h6>Ingrese Modificacion Unidad</h6>
                                    <vs-input
                                        class="inputx w-full  "
                                        v-model="descripcionUnidadMod"
                                    />
                                </div>
                                <div class="vx-col w-1/2">
                                    <h6>
                                        Marque solo si es un servicio
                                        despachable
                                    </h6>
                                    <br />

                                    <vs-checkbox
                                        class="px-32"
                                        v-model="VisualizarUnidadMod"
                                    ></vs-checkbox>
                                </div>
                            </div>
                            <br />
                            <div class="vx-row w-full">
                                <div class="vx-col w-1/2">
                                    <vs-button
                                        @click="popUpUnidad = false"
                                        color="primary"
                                        type="filled"
                                        class="w-full"
                                        >Volver</vs-button
                                    >
                                </div>
                                <div class="vx-col w-1/2">
                                    <vs-button
                                        @click="ModificarUnidad"
                                        color="success"
                                        type="filled"
                                        class="w-full"
                                        >Modificar Unidad</vs-button
                                    >
                                </div>
                            </div>
                        </vx-card>
                    </div>
                </div>
            </vs-popup>
            <!-- Sub-Unidad -->
            <vs-popup
                classContent="AgregarSubUnidad"
                title="Sub-Unidad"
                :active.sync="popUpSubUnidad"
            >
                <div class="vx-row w-full">
                    <div class="vx-col w-1/2 mt-5">
                        <vx-card title="Agregar Sub-Unidad">
                            <div class="vx-row w-full">
                                <div class="vx-col w-full">
                                    <h6>Seleccione Jerarquia</h6>
                                    <v-select
                                        v-model="seleccionSF1"
                                        placeholder="Ej. Direccion"
                                        class="w-full select-large"
                                        label="descripcionSF1"
                                        :options="listadoJerarquia"
                                        @input="CargaListadoSubJerarquia"
                                    ></v-select>
                                </div>
                            </div>
                            <br />
                            <div class="vx-row w-full">
                                <div class="vx-col w-full">
                                    <h6>Seleccione Sub-Jerarquia</h6>
                                    <v-select
                                        v-model="seleccionSF2"
                                        placeholder="Ej. Direccion"
                                        class="w-full select-large"
                                        label="descripcionSF2"
                                        :options="listadoSubJerarquia"
                                        @input="CargaListadoDepartamento"
                                    ></v-select>
                                </div>
                            </div>
                            <br />
                            <div class="vx-row w-full">
                                <div class="vx-col w-full">
                                    <h6>Seleccione Departamento</h6>
                                    <v-select
                                        v-model="seleccionSF3"
                                        placeholder="Ej. Direccion"
                                        class="w-full select-large"
                                        label="descripcionSF3"
                                        :options="listadoDepartamento"
                                        @input="CargaListadoUnidad"
                                    ></v-select>
                                </div>
                            </div>
                            <br />
                            <div class="vx-row w-full">
                                <div class="vx-col w-full">
                                    <h6>Seleccione Unidad</h6>
                                    <v-select
                                        v-model="seleccionSF4"
                                        placeholder="Ej. Direccion"
                                        class="w-full select-large"
                                        label="descripcionSF4"
                                        :options="listadoUnidad"
                                    ></v-select>
                                </div>
                            </div>
                            <br />
                            <div class="vx-row w-full">
                                <div class="vx-col w-1/2">
                                    <h6>Ingrese Descripcion Sub-Unidad</h6>
                                    <vs-input
                                        class="inputx w-full  "
                                        v-model="descripcionSubUnidad"
                                    />
                                </div>
                                <div class="vx-col w-1/2">
                                    <h6>
                                        Marque solo si es un servicio
                                        despachable
                                    </h6>
                                    <br />

                                    <vs-checkbox
                                        class="px-32"
                                        v-model="VisualizarSubUnidad"
                                    ></vs-checkbox>
                                </div>
                            </div>
                            <br />
                            <div class="vx-row w-full">
                                <div class="vx-col w-1/2">
                                    <vs-button
                                        @click="popUpSubUnidad = false"
                                        color="primary"
                                        type="filled"
                                        class="w-full"
                                        >Volver</vs-button
                                    >
                                </div>
                                <div class="vx-col w-1/2">
                                    <vs-button
                                        @click="AgregarSubUnidad"
                                        color="success"
                                        type="filled"
                                        class="w-full"
                                        >Agregar Sub-Unidad</vs-button
                                    >
                                </div>
                            </div>
                        </vx-card>
                    </div>
                    <div class="vx-col w-1/2 mt-5">
                        <vx-card title="Modificar Sub-Unidad">
                            <div class="vx-row w-full">
                                <div class="vx-col w-full">
                                    <h6>Seleccione Jerarquia</h6>
                                    <v-select
                                        v-model="seleccionSF1Mod"
                                        placeholder="Ej. Direccion"
                                        class="w-full select-large"
                                        label="descripcionSF1"
                                        :options="listadoJerarquia"
                                        @input="CargaListadoSubJerarquiaMod"
                                    ></v-select>
                                </div>
                            </div>
                            <br />
                            <div class="vx-row w-full">
                                <div class="vx-col w-full">
                                    <h6>Seleccione Sub-Jerarquia</h6>
                                    <v-select
                                        v-model="seleccionSF2Mod"
                                        placeholder="Ej. Direccion"
                                        class="w-full select-large"
                                        label="descripcionSF2"
                                        :options="listadoSubJerarquia"
                                        @input="CargaListadoDepartamentoMod"
                                    ></v-select>
                                </div>
                            </div>
                            <br />
                            <div class="vx-row w-full">
                                <div class="vx-col w-full">
                                    <h6>Seleccione Departamento</h6>
                                    <v-select
                                        v-model="seleccionSF3Mod"
                                        placeholder="Ej. Direccion"
                                        class="w-full select-large"
                                        label="descripcionSF3"
                                        :options="listadoDepartamento"
                                        @input="CargaListadoUnidadMod"
                                    ></v-select>
                                </div>
                            </div>
                            <br />
                            <div class="vx-row w-full">
                                <div class="vx-col w-full">
                                    <h6>Seleccione Unidad</h6>
                                    <v-select
                                        v-model="seleccionSF4Mod"
                                        placeholder="Ej. Direccion"
                                        class="w-full select-large"
                                        label="descripcionSF4"
                                        :options="listadoUnidad"
                                        @input="CargaListadoSubUnidadMod"
                                    ></v-select>
                                </div>
                            </div>
                            <br />
                            <div class="vx-row w-full">
                                <div class="vx-col w-full">
                                    <h6>Seleccione Sub-Unidad</h6>
                                    <v-select
                                        v-model="seleccionSF5Mod"
                                        placeholder="Ej. Direccion"
                                        class="w-full select-large"
                                        label="descripcionSF5"
                                        :options="listadoSubUnidad"
                                        @input="cargaSubUnidad"
                                    ></v-select>
                                </div>
                            </div>
                            <br />
                            <div class="vx-row">
                                <div class="vx-col w-1/2">
                                    <h6>Ingrese Modificacion Sub-Unidad</h6>
                                    <vs-input
                                        class="inputx w-full  "
                                        v-model="descripcionSubUnidadMod"
                                    />
                                </div>
                                <div class="vx-col w-1/2">
                                    <h6>
                                        Marque solo si es un servicio
                                        despachable
                                    </h6>
                                    <br />

                                    <vs-checkbox
                                        class="px-32"
                                        v-model="VisualizarSubUnidadMod"
                                    ></vs-checkbox>
                                </div>
                            </div>
                            <br />
                            <div class="vx-row w-full">
                                <div class="vx-col w-1/2">
                                    <vs-button
                                        @click="popUpSubUnidad = false"
                                        color="primary"
                                        type="filled"
                                        class="w-full"
                                        >Volver</vs-button
                                    >
                                </div>
                                <div class="vx-col w-1/2">
                                    <vs-button
                                        @click="ModificarSubUnidad"
                                        color="success"
                                        type="filled"
                                        class="w-full"
                                        >Modificar Sub-Unidad</vs-button
                                    >
                                </div>
                            </div>
                        </vx-card>
                    </div>
                </div>
            </vs-popup>
        </vx-card>
    </div>
</template>
<script>
import axios from "axios";
import router from "@/router";
import vSelect from "vue-select";
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import "quill/dist/quill.bubble.css";
import { quillEditor } from "vue-quill-editor";
import "vue-good-table/dist/vue-good-table.css";
import { VueGoodTable } from "vue-good-table";
import { PlusCircleIcon } from "vue-feather-icons";
import Vue from "vue";
import VueTippy, { TippyComponent } from "vue-tippy";
import { HotTable } from "@handsontable/vue";
import { ContextMenu } from "handsontable/plugins/contextMenu";
import { registerAllModules } from "handsontable/registry";
Vue.use(VueTippy);
Vue.component("tippy", TippyComponent);
registerAllModules();

export default {
    components: {
        VueGoodTable,
        "v-select": vSelect,
        quillEditor,
        PlusCircleIcon,
        HotTable
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
            settings: {
                colHeaders: [
                    "Direccion",
                    "Sub-Direccion",
                    "Departamento",
                    "Unidad",
                    "Sub-Unidad"
                ],
                licenseKey: "non-commercial-and-evaluation",
                contextMenu: {
                    items: {
                        row_above: {
                            name: "Insertar Fila Nueva hacia Arriba"
                        },
                        row_below: {
                            name: "Insertar Fila Nueva hacia Abajo"
                        },
                        separator: ContextMenu.SEPARATOR
                    }
                }
            },
            //Datos Campos
            //Jerarquia
            popUpJerarquia: false,
            popUpJerarquiaMod: false,
            descripcionJerarquia: "",
            descripcionJerarquiaMod: "",
            seleccionSF1: {
                id: 0,
                descripcionSF1: "Ej. Direccion"
            },
            seleccionSF1Mod: {
                id: 0,
                descripcionSF1: "Ej. Direccion"
            },
            listadoJerarquia: [],
            //SubJerarquia
            popUpSubJerarquia: false,
            popUpSubJerarquiaMod: false,
            descripcionSubJerarquia: "",
            descripcionSubJerarquiaMod: "",
            idSF1: "",
            seleccionSF2: {
                id: 0,
                descripcionSF2: "Ej. Direccion"
            },
            seleccionSF2Mod: {
                id: 0,
                descripcionSF2: "Ej. Direccion"
            },
            listadoSubJerarquia: [],
            //Departamento
            popUpDepartamento: false,
            popUpDepartamentoMod: false,
            VisualizarDepartamento: false,
            VisualizarDepartamentoMod: false,
            descripcionDepartamento: "",
            descripcionDepartamentoMod: "",
            idSF2: "",
            seleccionSF3: {
                id: 0,
                descripcionSF3: "Ej. Direccion"
            },
            seleccionSF3Mod: {
                id: 0,
                descripcionSF3: "Ej. Direccion"
            },
            listadoDepartamento: [],
            //Unidad
            popUpUnidad: false,
            popUpUnidadMod: false,
            VisualizarUnidad: false,
            VisualizarUnidadMod: false,
            descripcionUnidad: "",
            descripcionUnidadMod: "",
            idSF3: "",
            seleccionSF4: {
                id: 0,
                descripcionSF4: "Ej. Direccion"
            },
            seleccionSF4Mod: {
                id: 0,
                descripcionSF4: "Ej. Direccion"
            },
            listadoUnidad: [],
            //SubUnidad
            popUpSubUnidad: false,
            popUpSubUnidadMod: false,
            VisualizarSubUnidad: false,
            VisualizarSubUnidadMod: false,
            descripcionSubUnidad: "",
            descripcionSubUnidadMod: "",
            idSF4: "",
            seleccionSF5: {
                id: 0,
                descripcionSF5: "Ej. Direccion"
            },
            seleccionSF5Mod: {
                id: 0,
                descripcionSF5: "Ej. Direccion"
            },
            listadoSubUnidad: [],
            idMod: 0,
            //Template Columnas Listado Proveedor
            columns: [
                {
                    label: "Servicio",
                    field: "descripcionServicio",
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
            rows: []
        };
    },
    methods: {
        //Metodos Reusables
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
        limpiarCampos() {
            try {
                this.descripcionJerarquia = "";
                this.descripcionJerarquiaMod = "";
                this.descripcionSubJerarquia = "";
                this.descripcionSubJerarquiaMod = "";
                this.descripcionDepartamento = "";
                this.descripcionDepartamentoMod = "";
                this.descripcionUnidad = "";
                this.descripcionUnidadMod = "";
                this.descripcionSubUnidad = "";
                this.descripcionSubUnidadMod = "";
                this.seleccionSF1 = {
                    id: 0,
                    descripcionSF1: ""
                };
                this.seleccionSF2 = {
                    id: 0,
                    descripcionSF2: ""
                };
                this.seleccionSF3 = {
                    id: 0,
                    descripcionSF3: ""
                };
                this.seleccionSF4 = {
                    id: 0,
                    descripcionSF4: ""
                };
                this.seleccionSF5 = {
                    id: 0,
                    descripcionSF5: ""
                };
                this.seleccionSF1Mod = {
                    id: 0,
                    descripcionSF1: ""
                };
                this.seleccionSF2Mod = {
                    id: 0,
                    descripcionSF2: ""
                };
                this.seleccionSF3Mod = {
                    id: 0,
                    descripcionSF3: ""
                };
                this.seleccionSF4Mod = {
                    id: 0,
                    descripcionSF4: ""
                };
                this.seleccionSF5Mod = {
                    id: 0,
                    descripcionSF5: ""
                };
                this.listadoSubJerarquia = [];
                this.listadoDepartamento = [];
                this.listadoUnidad = [];
                this.listadoSubUnidad = [];
                this.idMod = 0;
            } catch (error) {
                console.log(error);
            }
        },
        //PopUp
        popJerarquia() {
            try {
                this.popUpJerarquia = true;
                this.limpiarCampos();
            } catch (error) {
                console.log(error);
            }
        },
        popSubJerarquia() {
            try {
                this.popUpSubJerarquia = true;
                this.limpiarCampos();
            } catch (error) {
                console.log(error);
            }
        },
        popDepartamento() {
            try {
                this.popUpDepartamento = true;
                this.limpiarCampos();
            } catch (error) {
                console.log(error);
            }
        },
        popUnidad() {
            try {
                this.popUpUnidad = true;
                this.limpiarCampos();
            } catch (error) {
                console.log(error);
            }
        },
        popSubUnidad() {
            try {
                this.popUpSubUnidad = true;
                this.limpiarCampos();
            } catch (error) {
                console.log(error);
            }
        },
        //Cargas de Datos Modificables u otros
        cargaJerarquia() {
            try {
                this.idMod = this.seleccionSF1Mod.id;
                this.descripcionJerarquiaMod = this.seleccionSF1Mod.descripcionSF1;
            } catch (error) {
                console.log(error);
            }
        },
        cargaSubJerarquia() {
            try {
                this.idMod = this.seleccionSF2Mod.id;
                this.descripcionSubJerarquiaMod = this.seleccionSF2Mod.descripcionSF2;
            } catch (error) {
                console.log(error);
            }
        },
        cargaDepartamento() {
            try {
                this.idMod = this.seleccionSF3Mod.id;
                this.descripcionDepartamentoMod = this.seleccionSF3Mod.descripcionSF3;
            } catch (error) {
                console.log(error);
            }
        },
        cargaUnidad() {
            try {
                this.idMod = this.seleccionSF4Mod.id;
                this.descripcionUnidadMod = this.seleccionSF4Mod.descripcionSF4;
            } catch (error) {
                console.log(error);
            }
        },
        cargaSubUnidad() {
            try {
                this.idMod = this.seleccionSF5Mod.id;
                this.descripcionSubUnidadMod = this.seleccionSF5Mod.descripcionSF5;
            } catch (error) {
                console.log(error);
            }
        },
        CargaListadoSubJerarquia() {
            try {
                this.TraerSubJerarquia();
                setTimeout(() => {
                    let c = this.listadoSubJerarquia;
                    let a = [];
                    c.forEach((value, index) => {
                        if (this.seleccionSF1.id == value.idSF1) {
                            a.push(value);
                        }
                    });
                    this.listadoSubJerarquia = [];
                    this.listadoSubJerarquia = a;
                }, 1000);
            } catch (error) {
                console.log(error);
            }
        },
        CargaListadoSubJerarquiaMod() {
            try {
                this.TraerSubJerarquia();
                setTimeout(() => {
                    let c = this.listadoSubJerarquia;
                    let a = [];
                    c.forEach((value, index) => {
                        if (this.seleccionSF1Mod.id == value.idSF1) {
                            a.push(value);
                        }
                    });
                    this.listadoSubJerarquia = [];
                    this.listadoSubJerarquia = a;
                }, 1000);
            } catch (error) {
                console.log(error);
            }
        },
        CargaListadoDepartamento() {
            try {
                this.TraerDepartamento();
                setTimeout(() => {
                    let c = this.listadoDepartamento;
                    let a = [];
                    c.forEach((value, index) => {
                        if (this.seleccionSF2.id == value.idSF2) {
                            a.push(value);
                        }
                    });
                    this.listadoDepartamento = [];
                    this.listadoDepartamento = a;
                }, 1000);
            } catch (error) {
                console.log(error);
            }
        },
        CargaListadoDepartamentoMod() {
            try {
                this.TraerDepartamento();
                setTimeout(() => {
                    let c = this.listadoDepartamento;
                    let a = [];
                    c.forEach((value, index) => {
                        if (this.seleccionSF2Mod.id == value.idSF2) {
                            a.push(value);
                        }
                    });
                    this.listadoDepartamento = [];
                    this.listadoDepartamento = a;
                }, 1000);
            } catch (error) {
                console.log(error);
            }
        },
        CargaListadoUnidad() {
            try {
                this.TraerUnidad();
                setTimeout(() => {
                    let c = this.listadoUnidad;
                    let a = [];
                    c.forEach((value, index) => {
                        if (this.seleccionSF3.id == value.idSF3) {
                            a.push(value);
                        }
                    });
                    this.listadoUnidad = [];
                    this.listadoUnidad = a;
                }, 1000);
            } catch (error) {
                console.log(error);
            }
        },
        CargaListadoUnidadMod() {
            try {
                this.TraerUnidad();
                setTimeout(() => {
                    let c = this.listadoUnidad;
                    let a = [];
                    c.forEach((value, index) => {
                        if (this.seleccionSF3Mod.id == value.idSF3) {
                            a.push(value);
                        }
                    });
                    this.listadoUnidad = [];
                    this.listadoUnidad = a;
                }, 1000);
            } catch (error) {
                console.log(error);
            }
        },
        CargaListadoSubUnidad() {
            try {
                this.TraerSubUnidad();
                setTimeout(() => {
                    let c = this.listadoSubUnidad;
                    let a = [];
                    c.forEach((value, index) => {
                        if (this.seleccionSF4.id == value.idSF4) {
                            a.push(value);
                        }
                    });
                    this.listadoSubUnidad = [];
                    this.listadoSubUnidad = a;
                }, 1000);
            } catch (error) {
                console.log(error);
            }
        },
        CargaListadoSubUnidadMod() {
            try {
                this.TraerSubUnidad();
                setTimeout(() => {
                    let c = this.listadoSubUnidad;
                    let a = [];
                    c.forEach((value, index) => {
                        if (this.seleccionSF4Mod.id == value.idSF4) {
                            a.push(value);
                        }
                    });
                    this.listadoSubUnidad = [];
                    this.listadoSubUnidad = a;
                }, 1000);
            } catch (error) {
                console.log(error);
            }
        },
        //Metodos CRUD Servicios
        //Jerarquia
        TraerJerarquia() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetSF1", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listadoJerarquia = res.data;
                        if (this.listadoJerarquia.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        AgregarJerarquia() {
            try {
                if (
                    this.descripcionJerarquia == "" ||
                    this.descripcionJerarquia == null
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar una descripcion",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let data = {
                        descripcionSF1: this.descripcionJerarquia.toUpperCase()
                    };

                    const dat = data;

                    axios
                        .post(this.localVal + "/api/Mantenedor/PostSF1", dat, {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        })
                        .then(res => {
                            const solicitudServer = res.data;
                            if (solicitudServer == true) {
                                this.limpiarCampos();
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Completado",
                                    text: "Jerarquia Ingresada Correctamente",
                                    color: "success",
                                    position: "top-right"
                                });
                                this.popUpJerarquia = false;
                                this.TraerJerarquia();
                            } else {
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Error",
                                    text:
                                        "No fue posible registrar la Jerarquia,intentelo nuevamente",
                                    color: "danger",
                                    position: "top-right"
                                });
                            }
                        });
                }
            } catch (error) {
                console.log(error);
            }
        },
        ModificarJerarquia() {
            try {
                if (
                    this.descripcionJerarquiaMod == "" ||
                    this.descripcionJerarquiaMod == null
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar una descripcion",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let data = {
                        id: this.seleccionSF1.id,
                        descripcionSF1: this.descripcionJerarquiaMod.toUpperCase()
                    };

                    const dat = data;

                    axios
                        .post(
                            this.localVal + "/api/Mantenedor/UpdateSF1",
                            dat,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            const solicitudServer = res.data;
                            if (solicitudServer == true) {
                                this.limpiarCampos();
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Completado",
                                    text: "Jerarquia Modificada Correctamente",
                                    color: "success",
                                    position: "top-right"
                                });
                                this.popUpJerarquia = false;
                                this.TraerJerarquia();
                            } else {
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Error",
                                    text:
                                        "No fue posible modificar la Jerarquia,intentelo nuevamente",
                                    color: "danger",
                                    position: "top-right"
                                });
                            }
                        });
                }
            } catch (error) {
                console.log(error);
            }
        },
        //Sub Jerarquia
        TraerSubJerarquia() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetSF2", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listadoSubJerarquia = res.data;
                        if (this.listadoSubJerarquia.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        AgregarSubJerarquia() {
            try {
                if (
                    this.descripcionSubJerarquia == "" ||
                    this.descripcionSubJerarquia == null
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar una descripcion",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let data = {
                        descripcionSF2: this.descripcionSubJerarquia.toUpperCase(),
                        idSF1: this.seleccionSF1.id
                    };

                    const dat = data;

                    axios
                        .post(this.localVal + "/api/Mantenedor/PostSF2", dat, {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        })
                        .then(res => {
                            const solicitudServer = res.data;
                            if (solicitudServer == true) {
                                this.limpiarCampos();
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Completado",
                                    text:
                                        "Sub-Jerarquia Ingresada Correctamente",
                                    color: "success",
                                    position: "top-right"
                                });
                                this.popUpSubJerarquia = false;
                                this.TraerSubJerarquia();
                            } else {
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Error",
                                    text:
                                        "No fue posible registrar la Sub-Jerarquia,intentelo nuevamente",
                                    color: "danger",
                                    position: "top-right"
                                });
                            }
                        });
                }
            } catch (error) {
                console.log(error);
            }
        },
        ModificarSubJerarquia() {
            try {
                if (
                    this.descripcionSubJerarquiaMod == "" ||
                    this.descripcionSubJerarquiaMod == null
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar una descripcion",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let data = {
                        id: this.seleccionSF2.id,
                        descripcionSF2: this.descripcionSubJerarquiaMod.toUpperCase(),
                        idSF1: this.seleccionSF1.id
                    };

                    const dat = data;

                    axios
                        .post(
                            this.localVal + "/api/Mantenedor/UpdateSF2",
                            dat,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            const solicitudServer = res.data;
                            if (solicitudServer == true) {
                                this.limpiarCampos();
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Completado",
                                    text:
                                        "Sub-Jerarquia Modificada Correctamente",
                                    color: "success",
                                    position: "top-right"
                                });
                                this.popUpSubJerarquia = false;
                                this.TraerSubJerarquia();
                            } else {
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Error",
                                    text:
                                        "No fue posible modificar la Sub-Jerarquia,intentelo nuevamente",
                                    color: "danger",
                                    position: "top-right"
                                });
                            }
                        });
                }
            } catch (error) {
                console.log(error);
            }
        },
        //Departamentos
        TraerDepartamento() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetSF3", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listadoDepartamento = res.data;
                        if (this.listadoDepartamento.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        AgregarDepartamento() {
            try {
                if (
                    this.descripcionDepartamento == "" ||
                    this.descripcionDepartamento == null
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar una descripcion",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let data = {
                        descripcionSF3: this.descripcionDepartamento.toUpperCase(),
                        idSF2: this.seleccionSF2.id,
                        visualizar: this.VisualizarDepartamento
                    };

                    const dat = data;

                    axios
                        .post(this.localVal + "/api/Mantenedor/PostSF3", dat, {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        })
                        .then(res => {
                            const solicitudServer = res.data;
                            if (solicitudServer == true) {
                                this.limpiarCampos();
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Completado",
                                    text:
                                        "Departamento Ingresado Correctamente",
                                    color: "success",
                                    position: "top-right"
                                });
                                this.popUpDepartamento = false;
                                this.TraerDepartamento();
                            } else {
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Error",
                                    text:
                                        "No fue posible registrar el departamento,intentelo nuevamente",
                                    color: "danger",
                                    position: "top-right"
                                });
                            }
                        });
                }
            } catch (error) {
                console.log(error);
            }
        },
        ModificarDepartamento() {
            try {
                if (
                    this.descripcionDepartamentoMod == "" ||
                    this.descripcionDepartamentoMod == null
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar una descripcion",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let data = {
                        id: this.seleccionSF3.id,
                        descripcionSF3: this.descripcionDepartamentoMod.toUpperCase(),
                        idSF2: this.seleccionSF2.id,
                        visualizar: this.VisualizarDepartamentoMod
                    };

                    const dat = data;

                    axios
                        .post(
                            this.localVal + "/api/Mantenedor/UpdateSF3",
                            dat,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            const solicitudServer = res.data;
                            if (solicitudServer == true) {
                                this.limpiarCampos();
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Completado",
                                    text:
                                        "Departamento Modificado Correctamente",
                                    color: "success",
                                    position: "top-right"
                                });
                                this.popUpDepartamento = false;
                                this.TraerDepartamento();
                            } else {
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Error",
                                    text:
                                        "No fue posible modificar el Departamento,intentelo nuevamente",
                                    color: "danger",
                                    position: "top-right"
                                });
                            }
                        });
                }
            } catch (error) {
                console.log(error);
            }
        },
        //Unidad
        TraerUnidad() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetSF4", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listadoUnidad = res.data;
                        if (this.listadoUnidad.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        AgregarUnidad() {
            try {
                if (
                    this.descripcionUnidad == "" ||
                    this.descripcionUnidad == null
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar una descripcion",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let data = {
                        descripcionSF4: this.descripcionUnidad.toUpperCase(),
                        idSF3: this.seleccionSF3.id,
                        visualizar: this.VisualizarUnidad
                    };

                    const dat = data;

                    axios
                        .post(this.localVal + "/api/Mantenedor/PostSF4", dat, {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        })
                        .then(res => {
                            const solicitudServer = res.data;
                            if (solicitudServer == true) {
                                this.limpiarCampos();
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Completado",
                                    text: "Unidad Ingresada Correctamente",
                                    color: "success",
                                    position: "top-right"
                                });
                                this.popUpUnidad = false;
                                this.TraerUnidad();
                            } else {
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Error",
                                    text:
                                        "No fue posible registrar la Unidad,intentelo nuevamente",
                                    color: "danger",
                                    position: "top-right"
                                });
                            }
                        });
                }
            } catch (error) {
                console.log(error);
            }
        },
        ModificarUnidad() {
            try {
                if (
                    this.descripcionUnidadMod == "" ||
                    this.descripcionUnidadMod == null
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar una descripcion",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let data = {
                        id: this.seleccionSF4.id,
                        descripcionSF4: this.descripcionUnidadMod.toUpperCase(),
                        idSF3: this.seleccionSF3.id,
                        visualizar: this.VisualizarUnidadMod
                    };

                    const dat = data;

                    axios
                        .post(
                            this.localVal + "/api/Mantenedor/UpdateSF4",
                            dat,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            const solicitudServer = res.data;
                            if (solicitudServer == true) {
                                this.limpiarCampos();
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Completado",
                                    text: "Unidad Modificada Correctamente",
                                    color: "success",
                                    position: "top-right"
                                });
                                this.popUpUnidad = false;
                                this.TraerUnidad();
                            } else {
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Error",
                                    text:
                                        "No fue posible modificar la Unidad,intentelo nuevamente",
                                    color: "danger",
                                    position: "top-right"
                                });
                            }
                        });
                }
            } catch (error) {
                console.log(error);
            }
        },
        //Sub Unidad
        TraerSubUnidad() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetSF5", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listadoSubUnidad = res.data;
                        if (this.listadoSubUnidad.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        AgregarSubUnidad() {
            try {
                if (
                    this.descripcionSubUnidad == "" ||
                    this.descripcionSubUnidad == null
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar una descripcion",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let data = {
                        descripcionSF5: this.descripcionSubUnidad.toUpperCase(),
                        idSF4: this.seleccionSF4.id,
                        visualizar: this.VisualizarSubUnidad
                    };

                    const dat = data;

                    axios
                        .post(this.localVal + "/api/Mantenedor/PostSF5", dat, {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        })
                        .then(res => {
                            const solicitudServer = res.data;
                            if (solicitudServer == true) {
                                this.limpiarCampos();
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Completado",
                                    text: "Sub Unidad Ingresada Correctamente",
                                    color: "success",
                                    position: "top-right"
                                });
                                this.popUpSubUnidad = false;
                                this.TraerSubUnidad();
                            } else {
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Error",
                                    text:
                                        "No fue posible registrar la Sub Unidad,intentelo nuevamente",
                                    color: "danger",
                                    position: "top-right"
                                });
                            }
                        });
                }
            } catch (error) {
                console.log(error);
            }
        },
        ModificarSubUnidad() {
            try {
                if (
                    this.descripcionSubUnidadMod == "" ||
                    this.descripcionSubUnidadMod == null
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar una descripcion",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    let data = {
                        id: this.seleccionSF5.id,
                        descripcionSF5: this.descripcionSubUnidadMod.toUpperCase(),
                        idSF4: this.seleccionSF4.id,
                        visualizar: this.VisualizarSubUnidadMod
                    };

                    const dat = data;

                    axios
                        .post(
                            this.localVal + "/api/Mantenedor/UpdateSF5",
                            dat,
                            {
                                headers: {
                                    Authorization:
                                        `Bearer ` +
                                        sessionStorage.getItem("token")
                                }
                            }
                        )
                        .then(res => {
                            const solicitudServer = res.data;
                            if (solicitudServer == true) {
                                this.limpiarCampos();
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Completado",
                                    text: "Sub Unidad Modificada Correctamente",
                                    color: "success",
                                    position: "top-right"
                                });
                                this.popUpSubUnidad = false;
                                this.TraerSubUnidad();
                            } else {
                                this.$vs.notify({
                                    time: 5000,
                                    title: "Error",
                                    text:
                                        "No fue posible modificar la Sub Unidad,intentelo nuevamente",
                                    color: "danger",
                                    position: "top-right"
                                });
                            }
                        });
                }
            } catch (error) {
                console.log(error);
            }
        },
        //Refresh Tokens
        RefreshToken() {
            try {
                let data = {
                    token: sessionStorage.getItem("token")
                };
                axios
                    .post(this.localVal + "/api/auth/RefreshToken", data)
                    .then(res => {
                        let tok = res.data;
                        if (tok == "") {
                        } else if (tok == false) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No se pudo refrescar su sesion, sera redirigido a el inicio de sesion",
                                color: "danger",
                                position: "top-right"
                            });
                            window.sessionStorage.clear();
                            window.localStorage.clear();
                            router.push("/pages/login");
                        } else {
                            sessionStorage.setItem("token", tok);
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        }
    },
    beforeMount() {
        this.RefreshToken();
        setTimeout(() => {
            this.TraerJerarquia();
            this.openLoadingColor();
        }, 2000);
    }
};
</script>
<style lang="stylus">
.con-vs-popup .vs-popup {
  width: 1500px;
}
</style>
<style src="./handsontable.full.css"></style>
