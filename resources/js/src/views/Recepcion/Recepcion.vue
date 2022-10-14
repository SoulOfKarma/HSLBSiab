<template>
    <div>
        <div class="vx-col md:w-1/1 w-full mb-base">
            <vx-card title="Recepciones">
                <div class="vx-row">
                    <div class="vx-col w-1/2 mt-5">
                        <vs-button
                            @click="FormRecepcion"
                            color="primary"
                            type="filled"
                            class="w-full"
                            >Formulario Recepcion</vs-button
                        >
                    </div>
                    <div class="vx-col w-1/2 mt-5">
                        <vs-button
                            @click="FormConsumoI"
                            color="success"
                            type="filled"
                            class="w-full"
                            >Formulario Consumo Inmediato</vs-button
                        >
                    </div>
                </div>
            </vx-card>
            <br />
            <!-- Recepcion -->
            <vx-card title="Recepcion Normal" v-if="recepcion">
                <div class="vx-row">
                    <div class="vx-col w-full mt-5">
                        <vs-button
                            @click="popArticulos"
                            color="primary"
                            type="filled"
                            class="w-full"
                            >Buscar Articulo</vs-button
                        >
                    </div>
                    <div
                        class="vx-col w-full mt-5"
                        v-if="listaDetalleRecepcion.length > 0"
                    >
                        <h6>N° Interno</h6>
                        <vs-input
                            class="inputx w-full  "
                            v-model="numint"
                            disabled
                        />
                    </div>
                    <div class="vx-col w-1/5 mt-5">
                        <h6>Fecha Sistema</h6>
                        <flat-pickr
                            :config="configFromdateTimePicker"
                            v-model="fechaSistema"
                            placeholder="Fecha Sistema"
                            class="w-full "
                            disabled
                        />
                    </div>
                    <div class="vx-col w-1/5 mt-5">
                        <h6>Fecha Inicio</h6>
                        <flat-pickr
                            :config="configFromdateTimePicker"
                            v-model="fechaRecepcion"
                            placeholder="Fecha Inicio"
                            @on-change="onFromChange"
                            class="w-full "
                        />
                    </div>
                    <div class="vx-col w-1/5 mt-5">
                        <h6>Proveedor</h6>
                        <v-select
                            v-model="seleccionProveedores"
                            placeholder="Activo"
                            class="w-full select-large"
                            label="RUTPROV"
                            :options="listadoProveedores"
                            @input="setProveedor"
                        ></v-select>
                    </div>
                    <div class="vx-col w-1/5 mt-5">
                        <h6>Nombre Proveedor</h6>
                        <vs-input
                            class="inputx w-full  "
                            v-model="descripcionProveedor"
                            disabled
                        />
                    </div>
                    <div class="vx-col w-1/5 mt-5">
                        <h6>Tipo Documento</h6>
                        <v-select
                            v-model="seleccionTipoDocumento"
                            placeholder="Activo"
                            class="w-full select-large"
                            label="descripcionDocumento"
                            :options="listaTipoDocumento"
                        ></v-select>
                    </div>
                    <div class="vx-col w-1/5 mt-5">
                        <h6>N° Documento</h6>
                        <vs-input
                            class="inputx w-full  "
                            v-model="ndocumento"
                        />
                    </div>
                    <div class="vx-col w-1/5 mt-5">
                        <h6>Fecha Documento</h6>
                        <flat-pickr
                            :config="configFromdateTimePicker"
                            v-model="fechaDocumento"
                            @on-change="onFromChange"
                            class="w-full "
                        />
                    </div>
                    <div class="vx-col w-1/5 mt-5">
                        <h6>Tipo Compra</h6>
                        <v-select
                            v-model="seleccionTipoCompra"
                            placeholder="Activo"
                            class="w-full select-large"
                            label="NOMTIPCOM"
                            :options="listadoTipoCompra"
                        ></v-select>
                    </div>
                    <div class="vx-col w-1/5 mt-5">
                        <h6>N° Orden Compra</h6>
                        <vs-input
                            class="inputx w-full  "
                            v-model="nordencompra"
                        />
                    </div>
                    <div class="vx-col w-1/5 mt-5">
                        <h6>N° RIB</h6>
                        <vs-input
                            class="inputx w-full  "
                            v-model="nrib"
                            @keypress="isNumber($event)"
                        />
                    </div>
                </div>
                <br />
                <div class="vx-row">
                    <div class="vx-col w-1/3 mt-5">
                        <h6>
                            Codigo de Barra
                        </h6>
                        <vs-input
                            class="inputx w-full  "
                            v-model="codigoBarra"
                            disabled
                        />
                    </div>
                    <div class="vx-col w-1/3 mt-5">
                        <h6>
                            Cantidad
                        </h6>
                        <vs-input
                            class="inputx w-full  "
                            v-model="cantidad"
                            @keypress="isNumber($event)"
                        />
                    </div>
                    <div class="vx-col w-1/3 mt-5">
                        <h6>
                            Precio
                        </h6>
                        <vs-input
                            class="inputx w-full  "
                            v-model="precio"
                            @keypress="isNumber($event)"
                        />
                    </div>

                    <div
                        class="vx-col w-1/2 mt-5"
                        v-if="seleccionFechaVencimiento.id == 1"
                    >
                        <h6>Fecha Vencimiento</h6>
                        <flat-pickr
                            :config="configTodateTimePickerFV"
                            v-model="fechaVencimiento"
                            @on-change="onFromChange"
                            class="w-full "
                        />
                    </div>
                    <div
                        class="vx-col w-1/2 mt-5"
                        v-if="seleccionLoteSerie.id == 1"
                    >
                        <h6>
                            Lote/Serie
                        </h6>
                        <vs-input class="inputx w-full  " v-model="lote" />
                    </div>

                    <br />
                    <div class="vx-col w-1/2 mt-5">
                        <vs-button
                            @click="limpiarCampos"
                            color="primary"
                            type="filled"
                            class="w-full"
                            >Limpiar Campos</vs-button
                        >
                    </div>
                    <div class="vx-col w-1/2 mt-5">
                        <vs-button
                            @click="AgregarArticuloDetalle"
                            color="success"
                            type="filled"
                            class="w-full"
                            >Agregar Articulo</vs-button
                        >
                    </div>
                </div>
                <br />
                <div
                    class="vx-col md:w-1/1 w-full mb-base mt-5"
                    v-if="listaDetalleRecepcion.length > 0"
                >
                    <div class="vx-row">
                        <div class="vx-col w-1/3 mt-5">
                            <vs-button
                                @click="popAgregarFactura"
                                color="primary"
                                type="filled"
                                class="w-full"
                                >ADJUNTAR FACTURA</vs-button
                            >
                        </div>
                        <div class="vx-col w-1/3 mt-5">
                            <vs-button
                                @click="popAgregarRIB"
                                color="primary"
                                type="filled"
                                class="w-full"
                                >ADJUNTAR RIB</vs-button
                            >
                        </div>
                        <div class="vx-col w-1/3 mt-5">
                            <vs-button
                                @click="popAgregarCarta"
                                color="primary"
                                type="filled"
                                class="w-full"
                                >ADJUNTAR CARTA</vs-button
                            >
                        </div>
                    </div>
                </div>
                <br />
                <!-- Detalles Articulos -->
                <div class="vx-col md:w-1/1 w-full mb-base mt-5">
                    <vx-card title="">
                        <div class="vx-row">
                            <vue-good-table
                                :columns="colDetalle"
                                class="w-full"
                                :rows="listaDetalleRecepcion"
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
                                    <span
                                        v-else-if="
                                            props.column.field === 'CODBAR'
                                        "
                                        class="text-nowrap"
                                    >
                                        <vs-input
                                            v-on:blur="
                                                ActCodigoBarra(
                                                    props.row.id,
                                                    props.row.CODBAR
                                                )
                                            "
                                            v-model="props.row.CODBAR"
                                            type="text"
                                            style="width:100px"
                                        ></vs-input>
                                    </span>
                                    <span
                                        v-else-if="
                                            props.column.field === 'ACT_FECVEN'
                                        "
                                        class="text-nowrap"
                                    >
                                        <vs-chip
                                            color="success"
                                            v-if="props.row.ACT_FECVEN == 1"
                                            v-model="FVEN1"
                                            type="text"
                                            style="width:100px"
                                            >Si</vs-chip
                                        >
                                        <vs-chip
                                            v-else
                                            color="primary"
                                            v-model="FVEN2"
                                            type="text"
                                            style="width:100px"
                                            >No</vs-chip
                                        >
                                    </span>
                                    <span
                                        v-else-if="
                                            props.column.field === 'FECVEN'
                                        "
                                        class="text-nowrap"
                                    >
                                        <vs-chip
                                            @click.native="
                                                popFechaVen(props.row.id)
                                            "
                                            color="primary"
                                            type="filled"
                                            class="w-full"
                                            >{{ props.row.FECVEN }}</vs-chip
                                        >
                                    </span>
                                    <span
                                        v-else-if="
                                            props.column.field === 'LOTE'
                                        "
                                        class="text-nowrap"
                                    >
                                        <vs-input
                                            v-on:blur="
                                                ActLote(
                                                    props.row.id,
                                                    props.row.LOTE
                                                )
                                            "
                                            v-model="props.row.LOTE"
                                            type="text"
                                            style="width:100px"
                                        ></vs-input>
                                    </span>
                                    <span
                                        v-else-if="
                                            props.column.field === 'CANREC'
                                        "
                                        class="text-nowrap"
                                    >
                                        <vs-input
                                            v-on:blur="
                                                ActCantRecepcionada(
                                                    props.row.id,
                                                    props.row.CANREC,
                                                    props.row.PREUNI
                                                )
                                            "
                                            v-model="props.row.CANREC"
                                            type="text"
                                            @keypress="isNumber($event)"
                                            style="width:100px"
                                        ></vs-input>
                                    </span>
                                    <span
                                        v-else-if="
                                            props.column.field === 'PREUNI'
                                        "
                                        class="text-nowrap"
                                    >
                                        <vs-input
                                            v-on:blur="
                                                ActPrecioUnitario(
                                                    props.row.id,
                                                    props.row.CANREC,
                                                    props.row.PREUNI
                                                )
                                            "
                                            v-model="props.row.PREUNI"
                                            type="text"
                                            @keypress="isNumber($event)"
                                            style="width:100px"
                                        ></vs-input>
                                    </span>
                                    <span
                                        v-else-if="
                                            props.column.field === 'action'
                                        "
                                    >
                                        <plus-circle-icon
                                            content="Eliminar Articulo del Detalle"
                                            v-tippy
                                            size="1.5x"
                                            class="custom-class"
                                            @click="popDelDetalle(props.row.id)"
                                        ></plus-circle-icon>
                                    </span>
                                    <!-- Column: Common -->
                                    <span v-else>
                                        {{
                                            props.formattedRow[
                                                props.column.field
                                            ]
                                        }}
                                    </span>
                                </template>
                            </vue-good-table>
                        </div>
                    </vx-card>
                    <div class="vx-row"></div>
                </div>
                <!-- Calculos -->
                <div class="vx-col md:w-1/1 w-full mb-base mt-5">
                    <vx-card title="">
                        <div class="vx-row">
                            <vue-good-table
                                class="w-full"
                                :columns="colTotal"
                                :rows="listaRecepcion"
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
                                    <span
                                        v-else-if="
                                            props.column.field === 'DCTO'
                                        "
                                        class="text-nowrap"
                                    >
                                        <vs-input
                                            v-on:blur="
                                                ActDCTO(
                                                    props.row.id,
                                                    props.row.DCTO
                                                )
                                            "
                                            v-model="props.row.DCTO"
                                            type="text"
                                            style="width:100px"
                                        ></vs-input>
                                    </span>
                                    <span
                                        v-else-if="
                                            props.column.field === 'CARGO'
                                        "
                                        class="text-nowrap"
                                    >
                                        <vs-input
                                            v-on:blur="
                                                ActCARGO(
                                                    props.row.id,
                                                    props.row.CARGO
                                                )
                                            "
                                            v-model="props.row.CARGO"
                                            type="text"
                                            style="width:100px"
                                        ></vs-input>
                                    </span>
                                    <span
                                        v-else-if="
                                            props.column.field === 'AJUSTE'
                                        "
                                        class="text-nowrap"
                                    >
                                        <vs-input
                                            v-on:blur="
                                                ActAJUSTE(
                                                    props.row.id,
                                                    props.row.AJUSTE
                                                )
                                            "
                                            v-model="props.row.AJUSTE"
                                            type="text"
                                            style="width:100px"
                                        ></vs-input>
                                    </span>
                                    <!-- Column: Common -->
                                    <span v-else>
                                        {{
                                            props.formattedRow[
                                                props.column.field
                                            ]
                                        }}
                                    </span>
                                </template>
                            </vue-good-table>
                        </div>
                    </vx-card>
                    <div class="vx-row"></div>
                </div>
                <div class="vx-col md:w-1/1 w-full mb-base mt-5">
                    <vx-card title="">
                        <div class="vx-row">
                            <h6>Observaciones</h6>
                            <br /><br />
                            <quill-editor
                                class="w-full"
                                v-model="Observaciones"
                                :options="editorOption"
                            >
                                <div id="toolbar" slot="toolbar"></div>
                            </quill-editor>
                        </div>
                        <br /><br />
                    </vx-card>
                </div>
                <div class="vx-col md:w-1/1 w-full mb-base mt-5">
                    <vx-card title="">
                        <div class="vx-row">
                            <div class="vx-col w-1/4 mt-5">
                                <vs-button
                                    @click="ActualizarListado"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Actualizar</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/4 mt-5">
                                <vs-button
                                    @click="ImprimirDatos"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Imprimir</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/4 mt-5">
                                <vs-button
                                    @click="volver"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/4 mt-5">
                                <vs-button
                                    @click="CerrarRecepcion"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Cerrar Recepcion</vs-button
                                >
                            </div>
                        </div>
                    </vx-card>
                </div>
            </vx-card>
            <!-- Consumo Inmediato -->
            <vx-card title="Consumo Inmediato" v-if="consumoi">
                <div class="vx-row">
                    <div class="vx-col w-full mt-5">
                        <vs-button
                            @click="popArticulos"
                            color="primary"
                            type="filled"
                            class="w-full"
                            >Buscar Articulo</vs-button
                        >
                    </div>
                    <div
                        class="vx-col w-full mt-5"
                        v-if="listaDetalleRecepcion.length > 0"
                    >
                        <h6>N° Interno</h6>
                        <vs-input
                            class="inputx w-full  "
                            v-model="numint"
                            disabled
                        />
                    </div>
                    <div class="vx-col w-1/5 mt-5">
                        <h6>Fecha Sistema</h6>
                        <flat-pickr
                            :config="configFromdateTimePicker"
                            v-model="fechaSistema"
                            placeholder="Fecha Sistema"
                            class="w-full "
                            disabled
                        />
                    </div>
                    <div class="vx-col w-1/5 mt-5">
                        <h6>Fecha Inicio</h6>
                        <flat-pickr
                            :config="configFromdateTimePicker"
                            v-model="fechaRecepcion"
                            placeholder="Fecha Inicio"
                            @on-change="onFromChange"
                            class="w-full "
                        />
                    </div>
                    <div class="vx-col w-1/5 mt-5">
                        <h6>Proveedor</h6>
                        <v-select
                            v-model="seleccionProveedores"
                            placeholder="Activo"
                            class="w-full select-large"
                            label="RUTPROV"
                            :options="listadoProveedores"
                            @input="setProveedor"
                        ></v-select>
                    </div>
                    <div class="vx-col w-1/5 mt-5">
                        <h6>Nombre Proveedor</h6>
                        <vs-input
                            class="inputx w-full  "
                            v-model="descripcionProveedor"
                            disabled
                        />
                    </div>
                    <div class="vx-col w-1/5 mt-5">
                        <h6>Tipo Documento</h6>
                        <v-select
                            v-model="seleccionTipoDocumento"
                            placeholder="Activo"
                            class="w-full select-large"
                            label="descripcionDocumento"
                            :options="listaTipoDocumento"
                        ></v-select>
                    </div>
                    <div class="vx-col w-1/5 mt-5">
                        <h6>N° Documento</h6>
                        <vs-input
                            class="inputx w-full  "
                            v-model="ndocumento"
                        />
                    </div>
                    <div class="vx-col w-1/5 mt-5">
                        <h6>Fecha Documento</h6>
                        <flat-pickr
                            :config="configFromdateTimePicker"
                            v-model="fechaDocumento"
                            @on-change="onFromChange"
                            class="w-full "
                        />
                    </div>
                    <div class="vx-col w-1/5 mt-5">
                        <h6>Tipo Compra</h6>
                        <v-select
                            v-model="seleccionTipoCompra"
                            placeholder="Activo"
                            class="w-full select-large"
                            label="NOMTIPCOM"
                            :options="listadoTipoCompra"
                        ></v-select>
                    </div>
                    <div class="vx-col w-1/5 mt-5">
                        <h6>N° Orden Compra</h6>
                        <vs-input
                            class="inputx w-full  "
                            v-model="nordencompra"
                        />
                    </div>
                    <div class="vx-col w-1/5 mt-5">
                        <h6>N° RIB</h6>
                        <vs-input
                            class="inputx w-full  "
                            v-model="nrib"
                            @keypress="isNumber($event)"
                        />
                    </div>
                </div>
                <br />
                <div class="vx-row">
                    <div class="vx-col w-full mt-5">
                        <h6>Servicio</h6>
                        <v-select
                            taggable
                            v-model="seleccionServicio"
                            placeholder="Servicio"
                            class="w-full select-large"
                            label="descripcionServicio"
                            :options="listadoServicios"
                        ></v-select>
                    </div>
                </div>

                <br />
                <div class="vx-row">
                    <div class="vx-col w-1/3 mt-5">
                        <h6>
                            Codigo de Barra
                        </h6>
                        <vs-input
                            class="inputx w-full  "
                            v-model="codigoBarra"
                            disabled
                        />
                    </div>
                    <div class="vx-col w-1/3 mt-5">
                        <h6>
                            Cantidad
                        </h6>
                        <vs-input
                            class="inputx w-full  "
                            v-model="cantidad"
                            @keypress="isNumber($event)"
                        />
                    </div>
                    <div class="vx-col w-1/3 mt-5">
                        <h6>
                            Precio
                        </h6>
                        <vs-input
                            class="inputx w-full  "
                            v-model="precio"
                            @keypress="isNumber($event)"
                        />
                    </div>

                    <div
                        class="vx-col w-1/2 mt-5"
                        v-if="seleccionFechaVencimiento.id == 1"
                    >
                        <h6>Fecha Venciminento</h6>
                        <flat-pickr
                            :config="configTodateTimePickerFV"
                            v-model="fechaVencimiento"
                            @on-change="onFromChange"
                            class="w-full "
                        />
                    </div>
                    <div
                        class="vx-col w-1/2 mt-5"
                        v-if="seleccionLoteSerie.id == 1"
                    >
                        <h6>
                            Lote/Serie
                        </h6>
                        <vs-input class="inputx w-full  " v-model="lote" />
                    </div>
                    <br />
                    <div class="vx-col w-1/2 mt-5">
                        <vs-button
                            @click="limpiarCampos"
                            color="primary"
                            type="filled"
                            class="w-full"
                            >Limpiar Campos</vs-button
                        >
                    </div>
                    <div class="vx-col w-1/2 mt-5">
                        <vs-button
                            @click="AgregarArticuloDetalle"
                            color="success"
                            type="filled"
                            class="w-full"
                            >Agregar Articulo</vs-button
                        >
                    </div>
                </div>
                <br />
                <div
                    class="vx-col md:w-1/1 w-full mb-base mt-5"
                    v-if="listaDetalleRecepcion.length > 0"
                >
                    <div class="vx-row">
                        <div class="vx-col w-1/3 mt-5">
                            <vs-button
                                @click="popAgregarFactura"
                                color="primary"
                                type="filled"
                                class="w-full"
                                >ADJUNTAR FACTURA</vs-button
                            >
                        </div>
                        <div class="vx-col w-1/3 mt-5">
                            <vs-button
                                @click="popAgregarRIB"
                                color="primary"
                                type="filled"
                                class="w-full"
                                >ADJUNTAR RIB</vs-button
                            >
                        </div>
                        <div class="vx-col w-1/3 mt-5">
                            <vs-button
                                @click="popAgregarCarta"
                                color="primary"
                                type="filled"
                                class="w-full"
                                >ADJUNTAR CARTA</vs-button
                            >
                        </div>
                    </div>
                </div>
                <br />
                <!-- Detalles Articulos -->
                <div class="vx-col md:w-1/1 w-full mb-base mt-5">
                    <vx-card title="">
                        <div class="vx-row">
                            <vue-good-table
                                :columns="colDetalle"
                                class="w-full"
                                :rows="listaDetalleRecepcion"
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
                                    <span
                                        v-else-if="
                                            props.column.field === 'CODBAR'
                                        "
                                        class="text-nowrap"
                                    >
                                        <vs-input
                                            v-on:blur="
                                                ActCodigoBarra(
                                                    props.row.id,
                                                    props.row.CODBAR
                                                )
                                            "
                                            v-model="props.row.CODBAR"
                                            type="text"
                                            style="width:100px"
                                        ></vs-input>
                                    </span>
                                    <span
                                        v-else-if="
                                            props.column.field === 'ACT_FECVEN'
                                        "
                                        class="text-nowrap"
                                    >
                                        <vs-chip
                                            color="success"
                                            v-if="props.row.ACT_FECVEN == 1"
                                            v-model="FVEN1"
                                            type="text"
                                            style="width:100px"
                                            >Si</vs-chip
                                        >
                                        <vs-chip
                                            v-else
                                            color="primary"
                                            v-model="FVEN2"
                                            type="text"
                                            style="width:100px"
                                            >No</vs-chip
                                        >
                                    </span>
                                    <span
                                        v-else-if="
                                            props.column.field === 'FECVEN'
                                        "
                                        class="text-nowrap"
                                    >
                                        <vs-chip
                                            @click.native="
                                                popFechaVen(props.row.id)
                                            "
                                            color="primary"
                                            type="filled"
                                            class="w-full"
                                            >{{ props.row.FECVEN }}</vs-chip
                                        >
                                    </span>
                                    <span
                                        v-else-if="
                                            props.column.field === 'LOTE'
                                        "
                                        class="text-nowrap"
                                    >
                                        <vs-input
                                            v-on:blur="
                                                ActLote(
                                                    props.row.id,
                                                    props.row.LOTE
                                                )
                                            "
                                            v-model="props.row.LOTE"
                                            type="text"
                                            style="width:300px"
                                        ></vs-input>
                                    </span>
                                    <span
                                        v-else-if="
                                            props.column.field === 'CANREC'
                                        "
                                        class="text-nowrap"
                                    >
                                        <vs-input
                                            v-on:blur="
                                                ActCantRecepcionada(
                                                    props.row.id,
                                                    props.row.CANREC,
                                                    props.row.PREUNI
                                                )
                                            "
                                            v-model="props.row.CANREC"
                                            type="text"
                                            @keypress="isNumber($event)"
                                            style="width:300px"
                                        ></vs-input>
                                    </span>
                                    <span
                                        v-else-if="
                                            props.column.field === 'PREUNI'
                                        "
                                        class="text-nowrap"
                                    >
                                        <vs-input
                                            v-on:blur="
                                                ActPrecioUnitario(
                                                    props.row.id,
                                                    props.row.CANREC,
                                                    props.row.PREUNI
                                                )
                                            "
                                            v-model="props.row.PREUNI"
                                            type="text"
                                            @keypress="isNumber($event)"
                                            style="width:300px"
                                        ></vs-input>
                                    </span>
                                    <span
                                        v-else-if="
                                            props.column.field === 'action'
                                        "
                                    >
                                        <plus-circle-icon
                                            content="Eliminar Articulo del Detalle"
                                            v-tippy
                                            size="1.5x"
                                            class="custom-class"
                                            @click="popDelDetalle(props.row.id)"
                                        ></plus-circle-icon>
                                    </span>
                                    <!-- Column: Common -->
                                    <span v-else>
                                        {{
                                            props.formattedRow[
                                                props.column.field
                                            ]
                                        }}
                                    </span>
                                </template>
                            </vue-good-table>
                        </div>
                    </vx-card>
                    <div class="vx-row"></div>
                </div>
                <!-- Calculos -->
                <div class="vx-col md:w-1/1 w-full mb-base mt-5">
                    <vx-card title="">
                        <div class="vx-row">
                            <vue-good-table
                                class="w-full"
                                :columns="colTotal"
                                :rows="listaRecepcion"
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
                                    <span
                                        v-else-if="
                                            props.column.field === 'DCTO'
                                        "
                                        class="text-nowrap"
                                    >
                                        <vs-input
                                            v-on:blur="
                                                ActDCTO(
                                                    props.row.id,
                                                    props.row.DCTO
                                                )
                                            "
                                            v-model="props.row.DCTO"
                                            type="text"
                                            style="width:300px"
                                        ></vs-input>
                                    </span>
                                    <span
                                        v-else-if="
                                            props.column.field === 'CARGO'
                                        "
                                        class="text-nowrap"
                                    >
                                        <vs-input
                                            v-on:blur="
                                                ActCARGO(
                                                    props.row.id,
                                                    props.row.CARGO
                                                )
                                            "
                                            v-model="props.row.CARGO"
                                            type="text"
                                            style="width:300px"
                                        ></vs-input>
                                    </span>
                                    <span
                                        v-else-if="
                                            props.column.field === 'AJUSTE'
                                        "
                                        class="text-nowrap"
                                    >
                                        <vs-input
                                            v-on:blur="
                                                ActAJUSTE(
                                                    props.row.id,
                                                    props.row.AJUSTE
                                                )
                                            "
                                            v-model="props.row.AJUSTE"
                                            type="text"
                                            style="width:300px"
                                        ></vs-input>
                                    </span>
                                    <!-- Column: Common -->
                                    <span v-else>
                                        {{
                                            props.formattedRow[
                                                props.column.field
                                            ]
                                        }}
                                    </span>
                                </template>
                            </vue-good-table>
                        </div>
                    </vx-card>
                    <div class="vx-row"></div>
                </div>
                <div class="vx-col md:w-1/1 w-full mb-base mt-5">
                    <vx-card title="">
                        <div class="vx-row">
                            <h6>Observaciones</h6>
                            <br /><br />
                            <quill-editor
                                class="w-full"
                                v-model="Observaciones"
                                :options="editorOption"
                            >
                                <div id="toolbar" slot="toolbar"></div>
                            </quill-editor>
                        </div>
                        <br /><br />
                    </vx-card>
                </div>
                <div class="vx-col md:w-1/1 w-full mb-base mt-5">
                    <vx-card title="">
                        <div class="vx-row">
                            <div class="vx-col w-1/4 mt-5">
                                <vs-button
                                    @click="ActualizarListado"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Actualizar</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/4 mt-5">
                                <vs-button
                                    @click="ImprimirDatos"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Imprimir</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/4 mt-5">
                                <vs-button
                                    @click="volver"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Volver</vs-button
                                >
                            </div>
                            <div class="vx-col w-1/4 mt-5">
                                <vs-button
                                    @click="CerrarRecepcion"
                                    color="primary"
                                    type="filled"
                                    class="w-full"
                                    >Cerrar Recepcion</vs-button
                                >
                            </div>
                        </div>
                    </vx-card>
                </div>
            </vx-card>
        </div>
        <!-- Listado Articulos -->
        <vs-popup
            classContent="ListadoArticulos"
            title="Listado Articulos"
            :active.sync="popUpArticulos"
        >
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="">
                    <div class="vx-row">
                        <vx-card>
                            <vue-good-table
                                :columns="col"
                                :rows="listaArticulos"
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
                                    <span
                                        v-else-if="
                                            props.column.field === 'action'
                                        "
                                    >
                                        <plus-circle-icon
                                            content="Agregar Articulo al listado"
                                            v-tippy
                                            size="1.5x"
                                            class="custom-class"
                                            @click="
                                                popAgregarArticulo(
                                                    props.row.NOMBRE,
                                                    props.row.UNIMEDBASE,
                                                    props.row.CODART_ONU,
                                                    props.row.CODART,
                                                    props.row.CODART_BARR,
                                                    props.row.idEstado,
                                                    props.row.UBICACION,
                                                    props.row.SECTOR,
                                                    props.row.idBodega,
                                                    props.row.idZona,
                                                    props.row.CANTXENB,
                                                    props.row.idACT_FECVEN,
                                                    props.row.idACTLOTE
                                                )
                                            "
                                        ></plus-circle-icon>
                                    </span>
                                    <!-- Column: Common -->
                                    <span v-else>
                                        {{
                                            props.formattedRow[
                                                props.column.field
                                            ]
                                        }}
                                    </span>
                                </template>
                            </vue-good-table>
                        </vx-card>
                    </div>
                </vx-card>
                <div class="vx-row"></div>
            </div>
        </vs-popup>
        <vs-popup
            classContent="Cambiar Fecha Vencimiento"
            title="Fecha Vencimiento"
            :active.sync="popUpFechaVen"
        >
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="">
                    <div class="vx-row">
                        <div class="vx-col w-full mt-5">
                            <h6>Fecha Vencimiento</h6>
                            <flat-pickr
                                :config="configTodateTimePickerFV"
                                v-model="fechaRecepcionAct"
                                placeholder="Fecha Inicio"
                                @on-change="onFromChange"
                                class="w-full "
                            />
                            <br />
                        </div>
                    </div>
                    <div class="vx-row">
                        <div class="vx-col w-1/2 mt-5">
                            <vs-button
                                @click="popUpFechaVen = false"
                                color="primary"
                                type="filled"
                                class="w-full"
                                >Volver</vs-button
                            >
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <vs-button
                                @click="ActFechaVencimiento"
                                color="primary"
                                type="filled"
                                class="w-full"
                                >Guardar</vs-button
                            >
                        </div>
                    </div>
                </vx-card>
                <div class="vx-row"></div>
            </div>
        </vs-popup>
        <vs-popup
            classContent="RemoverArticulo"
            title="Remover Articulo"
            :active.sync="popUpDelArt"
        >
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="">
                    <div class="vx-row">
                        <div class="vx-col w-1/2 mt-5">
                            <vs-button
                                @click="popUpDelArt = false"
                                color="primary"
                                type="filled"
                                class="w-full"
                                >Volver</vs-button
                            >
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <vs-button
                                @click="RemoverArticuloDetalle"
                                color="danger"
                                type="filled"
                                class="w-full"
                                >Remover</vs-button
                            >
                        </div>
                    </div>
                </vx-card>
                <div class="vx-row"></div>
            </div>
        </vs-popup>
        <!-- Documento Factura -->
        <vs-popup
            classContent="Factura"
            title="Factura"
            :active.sync="popUpAgregarFactura"
        >
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="">
                    <div class="vx-row mb-12">
                        <div class="vx-col w-1/8 mt-5">
                            <h6 class="pt-4 text-right">ADJUNTAR FACTURA</h6>
                        </div>
                        <div class="vx-col w-1/8 mt-5">
                            <vs-input
                                type="file"
                                id="archivo"
                                @change="getImage"
                                class="form-control w-full"
                            />
                        </div>

                        <div class="vx-col w-1/2 mt-5">
                            <h5 class="w-full pt-4 text-justify">
                                <p>
                                    {{ nombrearchivo }}
                                </p>
                            </h5>
                        </div>
                    </div>
                    <div class="vx-row">
                        <div class="vx-col w-1/2 mt-5">
                            <vs-button
                                @click="popUpAgregarFactura = false"
                                color="primary"
                                type="filled"
                                class="w-full"
                                >Volver</vs-button
                            >
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <vs-button
                                @click="uploadImage"
                                color="danger"
                                type="filled"
                                class="w-full"
                                >Subir Documento</vs-button
                            >
                        </div>
                    </div>
                </vx-card>
                <div class="vx-row"></div>
            </div>
        </vs-popup>
        <!-- Documento RIB -->
        <vs-popup classContent="RIB" title="RIB" :active.sync="popUpAgregarRIB">
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="">
                    <div class="vx-row mb-12">
                        <div class="vx-col w-1/8 mt-5">
                            <h6 class="pt-4 text-justify">ADJUNTAR RIB</h6>
                        </div>
                        <div class="vx-col w-1/8 mt-5">
                            <vs-input
                                type="file"
                                id="archivo"
                                @change="getImageRib"
                                class="form-control w-full"
                            />
                        </div>

                        <div class="vx-col w-1/2 mt-5">
                            <h5 class="w-full pt-4 text-justify">
                                <p>
                                    {{ nombrearchivoRib }}
                                </p>
                            </h5>
                        </div>
                    </div>
                    <div class="vx-row">
                        <div class="vx-col w-1/2 mt-5">
                            <vs-button
                                @click="popUpAgregarRIB = false"
                                color="primary"
                                type="filled"
                                class="w-full"
                                >Volver</vs-button
                            >
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <vs-button
                                @click="uploadImageRib"
                                color="danger"
                                type="filled"
                                class="w-full"
                                >Subir Documento</vs-button
                            >
                        </div>
                    </div>
                </vx-card>
                <div class="vx-row"></div>
            </div>
        </vs-popup>
        <!-- Documento CARTA -->
        <vs-popup
            classContent="CARTA"
            title="CARTA"
            :active.sync="popUpAgregarCarta"
        >
            <div class="vx-col md:w-1/1 w-full mb-base">
                <vx-card title="">
                    <div class="vx-row mb-12">
                        <div class="vx-col w-1/8 mt-5">
                            <h6 class="pt-4 text-justify">ADJUNTAR CARTA</h6>
                        </div>
                        <div class="vx-col w-1/8 mt-5">
                            <vs-input
                                type="file"
                                id="archivo"
                                @change="getImageCarta"
                                class="form-control w-full"
                            />
                        </div>

                        <div class="vx-col w-1/2 mt-5">
                            <h5 class="w-full pt-4 text-justify">
                                <p>
                                    {{ nombrearchivoCarta }}
                                </p>
                            </h5>
                        </div>
                    </div>
                    <div class="vx-row">
                        <div class="vx-col w-1/2 mt-5">
                            <vs-button
                                @click="popUpAgregarCarta = false"
                                color="primary"
                                type="filled"
                                class="w-full"
                                >Volver</vs-button
                            >
                        </div>
                        <div class="vx-col w-1/2 mt-5">
                            <vs-button
                                @click="uploadImageCarta"
                                color="danger"
                                type="filled"
                                class="w-full"
                                >Subir Documento</vs-button
                            >
                        </div>
                    </div>
                </vx-card>
                <div class="vx-row"></div>
            </div>
        </vs-popup>
    </div>
</template>
<script>
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
import moment from "moment";
import axios from "axios";
import vSelect from "vue-select";
import "quill/dist/quill.core.css";
import router from "@/router";
import "quill/dist/quill.snow.css";
import "quill/dist/quill.bubble.css";
import { quillEditor } from "vue-quill-editor";
import "vue-good-table/dist/vue-good-table.css";
import { VueGoodTable } from "vue-good-table";
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
            image: null,
            nombrearchivo: "",
            imageRib: null,
            nombrearchivoRib: "",
            imageCarta: null,
            nombrearchivoCarta: "",
            val_doc: 0,
            popUpAgregarFactura: false,
            popUpAgregarRIB: false,
            popUpAgregarCarta: false,
            FVEN1: "Si",
            FVEN2: "No",
            idFecha: 0,
            idRemoverArt: 0,
            popUpArticulos: false,
            recepcion: false,
            consumoi: false,
            popUpFechaVen: false,
            popUpDelArt: false,
            fechaAct: null,
            codInternoRecepcion: 0,
            descripcionServicio: "",
            ndocumento: "",
            cantidad: 0,
            precio: 0,
            numint: 0,
            valorTotal: 0,
            contador: 0,
            idServicio: 0,
            fechaSistema: null,
            fechaRecepcion: null,
            fechaDocumento: null,
            fechaVencimiento: null,
            fechaRecepcionAct: null,
            codigoBarra: "",
            Observaciones: "-",
            nordencompra: "",
            nrib: "",
            codigoTrack: "",
            codigoOnu: "",
            codigoArticulo: "",
            nombre: "",
            idEstado: "",
            generico: "",
            categoriaFarmacia: "",
            concentracion: "",
            lote: "",
            actFechaVencimiento: false,
            actLoteSerie: false,
            cantidadEmbalaje: "",
            idBodega: "",
            folio: 0,
            numintDespacho: 0,
            numFolioDespacho: 0,
            idZona: "",
            sector: "",
            ubicacion: "",
            unidadMedidaBase: "",
            descripcionProveedor: "",
            zgen: "",
            numeroLibroPedido: "-",
            tiporecepcion: "",
            dcto: 0,
            cargos: 0,
            ajustes: 0,
            seleccionEstado: {
                id: 0,
                descripcionEstado: ""
            },
            seleccionBodega: {
                id: 0,
                descripcionBodega: ""
            },
            seleccionZona: {
                id: 0,
                descripcionZonas: ""
            },
            seleccionFechaVencimiento: {
                id: 0,
                descripcionFVen: "Seleccione Fecha Venciminento"
            },
            seleccionLoteSerie: {
                id: 0,
                descripcionLoteSerie: "Seleccione Lote/Serie"
            },
            seleccionProveedores: {
                id: 0,
                RUTPROV: "Ej. 22222222-2",
                NOMRAZSOC: ""
            },
            seleccionTipoDocumento: {
                id: 0,
                descripcionDocumento: ""
            },
            seleccionTipoCompra: {
                id: 0,
                NOMTIPCOM: "Seleccione Tipo Compra"
            },
            seleccionServicio: {
                id: 0,
                descripcionServicio: ""
            },
            idMod: 0,
            //Datos Fechas
            configFromdateTimePicker: {
                minDate: null,
                maxDate: "today",
                dateFormat: "d/m/Y",
                allowInput: true,
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
                dateFormat: "d/m/Y",
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
            configTodateTimePickerFV: {
                minDate: null,
                maxDate: null,
                dateFormat: "d/m/Y",
                allowInput: true,
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
            //Configuracion Columnas
            colDetalle: [
                {
                    label: "Codigo Interno",
                    field: "CODART",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Especificacion Comprador",
                    field: "PRODUCTO",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Codigo Barra",
                    field: "CODBAR",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Unidad Medida",
                    field: "UNIMED",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Vencimiento Activo?",
                    field: "ACT_FECVEN",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Fecha Vencimiento",
                    field: "FECVEN",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Lote",
                    field: "LOTE",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Cantidad Recepcionada",
                    field: "CANREC",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Precio Unitario",
                    field: "PREUNI",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Total Recepcionado",
                    field: "VALTOT",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Opciones",
                    field: "action"
                }
            ],
            col: [
                {
                    label: "Codigo de Barra",
                    field: "CODART_BARR",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Bodega",
                    field: "descripcionBodega",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Codigo Articulo",
                    field: "CODART",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Nombre Articulo",
                    field: "NOMBRE",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Unidad de Medida",
                    field: "UNIMEDBASE",
                    filterOptions: {
                        enabled: true
                    }
                },
                {
                    label: "Opciones",
                    field: "action"
                }
            ],
            colTotal: [
                {
                    label: "NETO",
                    field: "NETO"
                },
                {
                    label: "Descuento",
                    field: "DCTO"
                },
                {
                    label: "Cargos",
                    field: "CARGO"
                },
                {
                    label: "Sub Total",
                    field: "SUBTOTAL"
                },
                {
                    label: "19% Iva",
                    field: "IVA"
                },
                {
                    label: "Ajuste",
                    field: "AJUSTE"
                },
                {
                    label: "Total",
                    field: "TOTAL"
                }
            ],
            //Datos Listado
            rows: [],
            listaArticulos: [],
            listaDetalleRecepcion: [],
            listaRecepcion: [],
            listaEstado: [],
            listaBodega: [],
            listaTipoDocumento: [],
            listaZona: [],
            listadoProveedores: [],
            listadoServicios: [],
            listadespachoDetalles: [],
            listadoTipoCompra: [],
            listadoTipoCompraTemporal: [],
            listaFVenciminento: [
                {
                    id: 1,
                    descripcionFVen: "Si"
                },
                {
                    id: 2,
                    descripcionFVen: "No"
                }
            ],
            listaFLoteSerie: [
                {
                    id: 1,
                    descripcionLoteSerie: "Si"
                },
                {
                    id: 2,
                    descripcionLoteSerie: "No"
                }
            ]
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
        FormRecepcion() {
            try {
                this.recepcion = true;
                this.consumoi = false;
                let c = this.listadoTipoCompraTemporal;
                let d = [];
                c.forEach((value, index) => {
                    if ("RECEPCION" == value.CATTIPCOM) {
                        d.push(value);
                    }
                });
                this.listadoTipoCompra = d;
                this.limpiarCampos();
                this.tiporecepcion = "Recepcion";
            } catch (error) {
                console.log(error);
            }
        },
        FormConsumoI() {
            try {
                this.consumoi = true;
                this.recepcion = false;
                let c = this.listadoTipoCompraTemporal;
                let d = [];
                c.forEach((value, index) => {
                    if ("CONSUMO INMEDIATO" == value.CATTIPCOM) {
                        d.push(value);
                    }
                });
                this.listadoTipoCompra = d;
                this.limpiarCampos();
                this.tiporecepcion = "Consumo Inmediato";
            } catch (error) {
                console.log(error);
            }
        },
        limpiarCampos() {
            try {
                this.cantidad = 0;
                this.precio = 0;
                this.codigoBarra = "";
                this.codigoOnu = "";
                this.codigoArticulo = "";
                this.nombre = "";
                this.nordencompra = "";
                this.seleccionEstado = {
                    id: 0,
                    descripcionEstado: ""
                };
                this.seleccionFechaVencimiento = {
                    id: 0,
                    descripcionFVen: "Seleccione Fecha Venciminento"
                };
                this.seleccionLoteSerie = {
                    id: 0,
                    descripcionLoteSerie: "Seleccione Lote/Serie"
                };
                this.cantidadEmbalaje = "";
                this.idBodega = 0;
                this.seleccionBodega = {
                    id: 0,
                    descripcionBodega: ""
                };
                this.idZona = 0;
                this.seleccionZona = {
                    id: 0,
                    descripcionZonas: ""
                };
                this.sector = "";
                this.ubicacion = "";
                this.unidadMedidaBase = "";
                this.idMod = 0;
                this.lote = "";
                this.numintDespacho = 0;
            } catch (error) {
                console.log(error);
            }
        },
        setProveedor() {
            try {
                this.descripcionProveedor = "";
                this.descripcionProveedor = this.seleccionProveedores.NOMRAZSOC;
            } catch (error) {
                console.log(error);
            }
        },
        ImprimirDatos() {
            try {
                if (this.numint != 0 && this.folio != 0) {
                    const url =
                        this.localVal +
                        "/api/Recepcion/RecepcionPDF/" +
                        this.numint;
                    window.open(url, "_blank");
                } else {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "No esta creado el Numero Interno",
                        color: "danger",
                        position: "top-right"
                    });
                }
            } catch (error) {
                console.log(error);
            }
        },
        //Guardar Documentos
        popAgregarFactura() {
            try {
                this.popUpAgregarFactura = true;
            } catch (error) {
                console.log(error);
            }
        },
        popAgregarRIB() {
            try {
                this.popUpAgregarRIB = true;
            } catch (error) {
                console.log(error);
            }
        },
        popAgregarCarta() {
            try {
                this.popUpAgregarCarta = true;
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
        getImageRib(event) {
            //Asignamos la imagen a  nuestra data
            this.imageRib = event.target.files[0];
            this.nombrearchivoRib = this.imageRib.name;
            this.val_doc = 1;
        },
        getImageCarta(event) {
            //Asignamos la imagen a  nuestra data
            this.imageCarta = event.target.files[0];
            this.nombrearchivoCarta = this.imageCarta.name;
            this.val_doc = 1;
        },
        uploadImage() {
            //Creamos el formData

            var data = new FormData();
            //Añadimos la imagen seleccionada
            data.append("avatar", this.image);
            data.append("id", this.numint);
            data.append("nombreDocOriginal", this.nombrearchivo);

            axios
                .post(
                    this.localVal +
                        "/api/Recepcion/PostDocumentoRecepcionFactura",
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
                        this.TraerRecepcion();
                    } else {
                        this.$vs.notify({
                            title: "Error al subir el documento ",
                            text:
                                "Intente nuevamente con el formato PDF o alguna Imagen ",
                            color: "danger",
                            position: "top-right"
                        });
                    }
                });
        },
        uploadImageRib() {
            //Creamos el formData

            var data = new FormData();
            //Añadimos la imagen seleccionada
            data.append("avatar", this.imageRib);
            data.append("id", this.numint);
            data.append("nombreDocOriginal", this.nombrearchivoRib);

            axios
                .post(
                    this.localVal +
                        "/api/Recepcion/PostDocumentoRecepcionFacturaRib",
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
                        this.TraerRecepcion();
                    } else {
                        this.$vs.notify({
                            title: "Error al subir el documento ",
                            text:
                                "Intente nuevamente con el formato PDF o alguna Imagen ",
                            color: "danger",
                            position: "top-right"
                        });
                    }
                });
        },
        uploadImageCarta() {
            //Creamos el formData

            var data = new FormData();
            //Añadimos la imagen seleccionada
            data.append("avatar", this.imageCarta);
            data.append("id", this.numint);
            data.append("nombreDocOriginal", this.nombrearchivoCarta);

            axios
                .post(
                    this.localVal +
                        "/api/Recepcion/PostDocumentoRecepcionFacturaCarta",
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
                        this.TraerRecepcion();
                    } else {
                        this.$vs.notify({
                            title: "Error al subir el documento ",
                            text:
                                "Intente nuevamente con el formato PDF o alguna Imagen ",
                            color: "danger",
                            position: "top-right"
                        });
                    }
                });
        },
        //Fin agregar documentos
        volver() {
            try {
                this.$router.push({
                    name: "home"
                });
            } catch (error) {
                console.log(error);
            }
        },
        ActDCTO(id, dcto) {
            try {
                this.dcto = dcto;
            } catch (error) {
                console.log(error);
            }
        },
        ActCARGO(id, cargo) {
            try {
                this.cargos = cargo;
            } catch (error) {
                console.log(error);
            }
        },
        ActAJUSTE(id, ajuste) {
            try {
                this.ajustes = ajuste;
            } catch (error) {
                console.log(error);
            }
        },
        ActLote(id, lote) {
            try {
                let c = this.listaDetalleRecepcion;

                c.forEach((value, index) => {
                    if (id == value.id) {
                        value.LOTE = lote;
                    }
                });

                this.listaDetalleRecepcion = c;
            } catch (error) {
                console.log(error);
            }
        },
        ActCodigoBarra(id, codigoBarra) {
            try {
                let c = this.listaDetalleRecepcion;

                c.forEach((value, index) => {
                    if (id == value.id) {
                        value.CODBAR = codigoBarra;
                    }
                });

                this.listaDetalleRecepcion = c;
            } catch (error) {
                console.log(error);
            }
        },
        ActFechaVencimiento() {
            try {
                let id = this.idFecha;
                let c = this.listaDetalleRecepcion;
                c.forEach((value, index) => {
                    if (id == value.id) {
                        value.FECVEN = moment(
                            this.fechaAct,
                            "DD-MM-YYYY"
                        ).format("YYYY-MM-DD");
                    }
                });

                this.listaDetalleRecepcion = c;
                this.popUpFechaVen = false;
            } catch (error) {
                console.log(error);
            }
        },
        ActCantRecepcionada(id, cantRecepcionada, precioUnitario) {
            try {
                let c = this.listaDetalleRecepcion;
                let total =
                    parseInt(cantRecepcionada) * parseInt(precioUnitario);
                c.forEach((value, index) => {
                    if (id == value.id) {
                        value.CANREC = cantRecepcionada;
                        value.VALTOT = total;
                    }
                });

                this.listaDetalleRecepcion = c;
            } catch (error) {
                console.log(error);
            }
        },
        ActPrecioUnitario(id, cantRecepcionada, precioUnitario) {
            try {
                let c = this.listaDetalleRecepcion;
                let total =
                    parseInt(cantRecepcionada) * parseInt(precioUnitario);
                c.forEach((value, index) => {
                    if (id == value.id) {
                        value.PREUNI = precioUnitario;
                        value.VALTOT = total;
                    }
                });

                this.listaDetalleRecepcion = c;
            } catch (error) {
                console.log(error);
            }
        },
        //PopUp
        popArticulos() {
            try {
                this.popUpArticulos = true;
            } catch (error) {
                console.log(error);
            }
        },
        popFechaVen(id) {
            try {
                this.idFecha = id;
                this.popUpFechaVen = true;
            } catch (error) {
                console.log(error);
            }
        },
        popDelDetalle(id) {
            try {
                this.idRemoverArt = id;
                this.popUpDelArt = true;
            } catch (error) {
                console.log(error);
            }
        },
        popAgregarArticulo(
            NOMBRE,
            UNIMEDBASE,
            CODART_ONU,
            CODART,
            CODART_BARR,
            idEstado,
            UBICACION,
            SECTOR,
            idBodega,
            idZona,
            CANTXENB,
            idACT_FECVEN,
            idACTLOTE
        ) {
            try {
                //this.limpiarCampos();
                this.popUpCodInsumoEco = true;
                this.codigoBarra = CODART_BARR;
                this.codigoOnu = CODART_ONU;
                this.codigoArticulo = CODART;
                this.nombre = NOMBRE;
                let c = this.listaEstado;

                c.forEach((value, index) => {
                    if (idEstado == value.id) {
                        this.seleccionEstado.id = value.id;
                        this.seleccionEstado.descripcionEstado =
                            value.descripcionEstado;
                    }
                });

                c = [];
                if (idACT_FECVEN == 1) {
                    this.seleccionFechaVencimiento = {
                        id: 1,
                        descripcionFVen: "Si"
                    };
                } else {
                    this.seleccionFechaVencimiento = {
                        id: 2,
                        descripcionFVen: "No"
                    };

                    this.fechaVencimiento = null;
                }

                if (idACTLOTE == 1) {
                    this.seleccionLoteSerie = {
                        id: 1,
                        descripcionLoteSerie: "Si"
                    };
                } else {
                    this.seleccionLoteSerie = {
                        id: 2,
                        descripcionLoteSerie: "No"
                    };
                }

                this.cantidadEmbalaje = CANTXENB;
                this.idBodega = 0;

                c = this.listaBodega;

                c.forEach((value, index) => {
                    if (idBodega == value.id) {
                        this.seleccionBodega.id = value.id;
                        this.seleccionBodega.descripcionBodega =
                            value.descripcionBodega;
                    }
                });

                c = [];

                this.idZona = 0;

                c = this.listaZona;

                c.forEach((value, index) => {
                    if (idZona == value.id) {
                        this.seleccionZona.id = value.id;
                        this.seleccionZona.descripcionZonas =
                            value.descripcionZonas;
                    }
                });

                c = [];
                this.sector = SECTOR;
                this.ubicacion = UBICACION;

                this.unidadMedidaBase = UNIMEDBASE;
                this.popUpArticulos = false;
            } catch (error) {
                console.log(error);
            }
        },
        //Metodos CRUD
        TraerTipoCompra() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetTipoCompras", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listadoTipoCompraTemporal = res.data;
                        if (this.listadoTipoCompraTemporal.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los Laboratorios correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
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
        TraerArticulos() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetAllArticulos", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listaArticulos = res.data;
                        if (this.listaArticulos.length < 0) {
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
        TraerDetalleRecepcion() {
            try {
                let data = {
                    NUMINT: this.numint
                };

                axios
                    .post(
                        this.localVal +
                            "/api/Mantenedor/GetArticulosIngresadosByCodInterno",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.listaDetalleRecepcion = res.data;
                        if (this.listaDetalleRecepcion.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        } else {
                            let c = this.listaDetalleRecepcion;
                            let a = 0;
                            c.forEach((value, index) => {
                                a = a + parseInt(value.VALTOT);
                            });
                            this.valorTotal = a;
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        TraerRecepcion() {
            try {
                let data = {
                    NUMINT: this.numint
                };
                axios
                    .post(
                        this.localVal +
                            "/api/Mantenedor/GetRecepcionIngresadaByCodInterno",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.listaRecepcion = res.data;
                        if (this.listaRecepcion.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        } else {
                            let c = this.listaRecepcion;
                            let idDoc = 0;
                            let idServicio = 0;
                            let tipord = "";
                            c.forEach((value, index) => {
                                this.fechaSistema = moment(value.FECSYS)
                                    .format("DD/MM/YYYY")
                                    .toString();
                                this.fechaRecepcion = moment(value.FECDES)
                                    .format("DD/MM/YYYY")
                                    .toString();
                                this.seleccionProveedores.RUTPROV =
                                    value.RUTPRO;
                                this.seleccionProveedores.NOMRAZSOC =
                                    value.NOMPRO;
                                this.descripcionProveedor = value.NOMPRO;
                                idDoc = value.TIPDOC;
                                this.ndocumento = value.NUMDOC;
                                this.fechaDocumento = moment(value.FECDOC)
                                    .format("DD/MM/YYYY")
                                    .toString();
                                this.nordencompra = value.NUMORD;
                                this.nrib = value.NUMRIB;
                                this.tiporecepcion = value.TIPRECEPCION;
                                this.numeroLibroPedido = value.NUMLIBPED;
                                this.Observaciones = value.OBS;
                                idServicio = value.idServicio;
                                tipord = value.TIPORD;
                            });

                            let f = this.listadoTipoCompraTemporal;
                            let g = [];
                            f.forEach((value, index) => {
                                if (
                                    this.tiporecepcion.toUpperCase() ==
                                    value.CATTIPCOM
                                ) {
                                    g.push(value);
                                    if (tipord == value.NOMTIPCOM) {
                                        this.seleccionTipoCompra.id = value.id;
                                        this.seleccionTipoCompra.NOMTIPCOM =
                                            value.NOMTIPCOM;
                                    }
                                }
                            });

                            this.listadoTipoCompra = g;
                            this.fechaVencimiento = null;

                            c = [];

                            c = this.listaTipoDocumento;
                            c.forEach((value, index) => {
                                if (idDoc == value.id) {
                                    this.seleccionTipoDocumento.id;
                                    this.seleccionTipoDocumento.descripcionDocumento =
                                        value.descripcionDocumento;
                                }
                            });

                            c = [];
                            c = this.listadoServicios;
                            c.forEach((value, index) => {
                                if (idServicio == value.id) {
                                    this.seleccionServicio.id = idServicio;
                                    this.seleccionServicio.descripcionServicio =
                                        value.descripcionServicio;
                                }
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        TraerDetalleDespachos() {
            try {
                let data = {
                    NUMINT: this.numintDespacho
                };
                axios
                    .post(
                        this.localVal + "/api/Mantenedor/GetDespachoDetalles",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        this.listadespachoDetalles = res.data;
                        if (this.listadespachoDetalles.length < 0) {
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
        TraerProveedores() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetProveedor", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listadoProveedores = res.data;
                        if (this.listadoProveedores.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los proveedores correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        TraerTipoDocumentos() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetTipoDocumentos", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listaTipoDocumento = res.data;
                        if (this.listaTipoDocumento.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los proveedores correctamente",
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
                        this.listaEstado = res.data;
                        if (this.listaEstado.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos de Estado correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        TraerBodega() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetBodega", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listaBodega = res.data;
                        if (this.listaBodega.length < 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No hay datos o no se cargaron los datos de las Bodegas correctamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        TraerZona() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetZona", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        this.listaZona = res.data;
                        if (this.listaZona.length < 0) {
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
        TraerUltimoNInterno() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetUltimoNInterno", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        let data = res.data[0].NUMINT;
                        if (
                            data == 0 ||
                            data == null ||
                            data == [] ||
                            data == {}
                        ) {
                            this.numint = 1;
                        } else {
                            this.numint = data + 1;
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        TraerUltimoNFolio() {
            try {
                axios
                    .get(this.localVal + "/api/Mantenedor/GetUltimoNFolio", {
                        headers: {
                            Authorization:
                                `Bearer ` + sessionStorage.getItem("token")
                        }
                    })
                    .then(res => {
                        let data = res.data[0].FOLIO;
                        if (
                            data == 0 ||
                            data == null ||
                            data == [] ||
                            data == {}
                        ) {
                            this.folio = 1;
                        } else {
                            this.folio = data + 1;
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        AgregarArticuloDetalle() {
            try {
                if (this.precio == null || this.precio < 1) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe Ingresar un Precio",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.cantidad == null || this.cantidad < 1) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe Ingresar una cantidad",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.fechaRecepcion == null) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe seleccionar una fecha de recepcion",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (
                    this.seleccionProveedores.id == 0 ||
                    this.seleccionProveedores.id == null ||
                    this.seleccionProveedores.id == ""
                ) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe seleccionar un proveedor",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.codigoBarra == null || this.codigoBarra == "") {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe seleccionar un articulo",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.cantidad == null || this.cantidad < 1) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar una cantidad no menor a 1",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (this.precio == null || this.precio < 1) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text: "Debe ingresar un precio no menor a 1",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    if (this.seleccionFechaVencimiento.id == 1) {
                        if (this.fechaVencimiento != null) {
                            let total = this.precio * this.cantidad;
                            let valorT = total + parseInt(this.valorTotal);
                            let nombreUsuario =
                                sessionStorage.getItem("nombre") +
                                " " +
                                sessionStorage.getItem("apellido");

                            if (this.fechaVencimiento != null) {
                                this.fechaVencimiento = moment(
                                    this.fechaVencimiento,
                                    "DD-MM-YYYY"
                                ).format("YYYY-MM-DD");
                            }
                            let data = {
                                NUMINT: this.numint,
                                FECSYS: moment(
                                    this.fechaSistema,
                                    "DD-MM-YYYY"
                                ).format("YYYY-MM-DD"),
                                FECDES: moment(
                                    this.fechaRecepcion,
                                    "DD-MM-YYYY"
                                ).format("YYYY-MM-DD"),
                                RUTPRO: this.seleccionProveedores.RUTPROV,
                                NOMPRO: this.seleccionProveedores.NOMRAZSOC.toUpperCase(),
                                TIPDOC: this.seleccionTipoDocumento.id,
                                NUMDOC: this.ndocumento.toUpperCase(),
                                FECDOC: moment(
                                    this.fechaDocumento,
                                    "DD-MM-YYYY"
                                ).format("YYYY-MM-DD"),
                                NUMORD: this.nordencompra.toUpperCase(),
                                NUMRIB: this.nrib,
                                CODART: this.codigoArticulo.toUpperCase(),
                                PRODUCTO: this.nombre.toUpperCase(),
                                CODBAR: this.codigoBarra.toUpperCase(),
                                UNIMED: this.unidadMedidaBase.toUpperCase(),
                                ACT_FECVEN: this.seleccionFechaVencimiento.id,
                                FECVEN: this.fechaVencimiento,
                                LOTE: this.lote,
                                CANREC: this.cantidad,
                                CANRECH: 0,
                                PENDIENTE: 0,
                                PREUNI: this.precio,
                                VALTOT: total,
                                DCTO: 0,
                                OBS: this.Observaciones.toUpperCase(),
                                CARGO: 0,
                                SUBTOTAL: valorT,
                                AJUSTE: 0,
                                USUING: nombreUsuario.toUpperCase(),
                                idServicio: this.seleccionServicio.id,
                                NUMLIBPED: this.numeroLibroPedido,
                                TIPRECEPCION: this.tiporecepcion,
                                TIPORD: this.seleccionTipoCompra.NOMTIPCOM
                            };
                            const dat = data;

                            if (this.contador > 0) {
                                axios
                                    .post(
                                        this.localVal +
                                            "/api/Mantenedor/PostArticuloDetalleCodInterno",
                                        dat,
                                        {
                                            headers: {
                                                Authorization:
                                                    `Bearer ` +
                                                    sessionStorage.getItem(
                                                        "token"
                                                    )
                                            }
                                        }
                                    )
                                    .then(res => {
                                        const solicitudServer = res.data;
                                        if (solicitudServer == true) {
                                            this.$vs.notify({
                                                time: 5000,
                                                title: "Completado",
                                                text:
                                                    "Articulo Ingresado al detalle Correctamente",
                                                color: "success",
                                                position: "top-right"
                                            });
                                            this.TraerDetalleRecepcion();
                                            this.TraerRecepcion();
                                        } else {
                                            this.$vs.notify({
                                                time: 5000,
                                                title: "Error",
                                                text:
                                                    "No fue posible agregar el Articulo al detalle,intentelo nuevamente",
                                                color: "danger",
                                                position: "top-right"
                                            });
                                        }
                                    });
                            } else {
                                axios
                                    .post(
                                        this.localVal +
                                            "/api/Mantenedor/PostArticuloDetalle",
                                        dat,
                                        {
                                            headers: {
                                                Authorization:
                                                    `Bearer ` +
                                                    sessionStorage.getItem(
                                                        "token"
                                                    )
                                            }
                                        }
                                    )
                                    .then(res => {
                                        const solicitudServer = res.data;
                                        if (solicitudServer == true) {
                                            this.$vs.notify({
                                                time: 5000,
                                                title: "Completado",
                                                text:
                                                    "Articulo Ingresado al detalle Correctamente",
                                                color: "success",
                                                position: "top-right"
                                            });
                                            this.TraerDetalleRecepcion();
                                            this.TraerRecepcion();
                                            this.contador = 1;
                                        } else {
                                            this.$vs.notify({
                                                time: 5000,
                                                title: "Error",
                                                text:
                                                    "No fue posible agregar el Articulo al detalle,intentelo nuevamente",
                                                color: "danger",
                                                position: "top-right"
                                            });
                                        }
                                    });
                            }
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "Debe ingresar una fecha de vencimiento para continuar",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    } else {
                        let total = this.precio * this.cantidad;
                        let valorT = total + parseInt(this.valorTotal);
                        let nombreUsuario =
                            sessionStorage.getItem("nombre") +
                            " " +
                            sessionStorage.getItem("apellido");

                        let data = {
                            NUMINT: this.numint,
                            FECSYS: moment(
                                this.fechaSistema,
                                "DD-MM-YYYY"
                            ).format("YYYY-MM-DD"),
                            FECDES: moment(
                                this.fechaRecepcion,
                                "DD-MM-YYYY"
                            ).format("YYYY-MM-DD"),
                            RUTPRO: this.seleccionProveedores.RUTPROV,
                            NOMPRO: this.seleccionProveedores.NOMRAZSOC.toUpperCase(),
                            TIPDOC: this.seleccionTipoDocumento.id,
                            NUMDOC: this.ndocumento.toUpperCase(),
                            FECDOC: moment(
                                this.fechaDocumento,
                                "DD-MM-YYYY"
                            ).format("YYYY-MM-DD"),
                            NUMORD: this.nordencompra.toUpperCase(),
                            NUMRIB: this.nrib,
                            CODART: this.codigoArticulo.toUpperCase(),
                            PRODUCTO: this.nombre.toUpperCase(),
                            CODBAR: this.codigoBarra.toUpperCase(),
                            UNIMED: this.unidadMedidaBase.toUpperCase(),
                            ACT_FECVEN: this.seleccionFechaVencimiento.id,
                            LOTE: this.lote,
                            CANREC: this.cantidad,
                            CANRECH: 0,
                            PENDIENTE: 0,
                            PREUNI: this.precio,
                            VALTOT: total,
                            DCTO: 0,
                            OBS: this.Observaciones.toUpperCase(),
                            CARGO: 0,
                            SUBTOTAL: valorT,
                            AJUSTE: 0,
                            USUING: nombreUsuario.toUpperCase(),
                            idServicio: this.seleccionServicio.id,
                            NUMLIBPED: this.numeroLibroPedido,
                            TIPRECEPCION: this.tiporecepcion,
                            TIPORD: this.seleccionTipoCompra.NOMTIPCOM
                        };
                        const dat = data;

                        if (this.contador > 0) {
                            axios
                                .post(
                                    this.localVal +
                                        "/api/Mantenedor/PostArticuloDetalleCodInterno",
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
                                        this.$vs.notify({
                                            time: 5000,
                                            title: "Completado",
                                            text:
                                                "Articulo Ingresado al detalle Correctamente",
                                            color: "success",
                                            position: "top-right"
                                        });
                                        this.TraerDetalleRecepcion();
                                        this.TraerRecepcion();
                                    } else {
                                        this.$vs.notify({
                                            time: 5000,
                                            title: "Error",
                                            text:
                                                "No fue posible agregar el Articulo al detalle,intentelo nuevamente",
                                            color: "danger",
                                            position: "top-right"
                                        });
                                    }
                                });
                        } else {
                            axios
                                .post(
                                    this.localVal +
                                        "/api/Mantenedor/PostArticuloDetalle",
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
                                        this.$vs.notify({
                                            time: 5000,
                                            title: "Completado",
                                            text:
                                                "Articulo Ingresado al detalle Correctamente",
                                            color: "success",
                                            position: "top-right"
                                        });
                                        this.TraerDetalleRecepcion();
                                        this.TraerRecepcion();
                                        this.contador = 1;
                                    } else {
                                        this.$vs.notify({
                                            time: 5000,
                                            title: "Error",
                                            text:
                                                "No fue posible agregar el Articulo al detalle,intentelo nuevamente",
                                            color: "danger",
                                            position: "top-right"
                                        });
                                    }
                                });
                        }
                    }
                }
            } catch (error) {
                console.log(error);
            }
        },
        TraerUltimoNInternoDespacho() {
            try {
                axios
                    .get(
                        this.localVal +
                            "/api/Despachos/GetUltimoNInternoDespacho",
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        let nintDes = res.data[0].NUMINT;
                        if (
                            nintDes == 0 ||
                            nintDes == null ||
                            nintDes == [] ||
                            nintDes == {}
                        ) {
                            this.numintDespacho = 1;
                        } else {
                            this.numintDespacho = nintDes + 1;
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        TraerUltimoNFolioDespacho() {
            try {
                axios
                    .get(
                        this.localVal +
                            "/api/Despachos/GetUltimoNFolioDespacho",
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        let data = res.data[0].FOLIO;
                        if (
                            data == 0 ||
                            data == null ||
                            data == [] ||
                            data == {}
                        ) {
                            this.numFolioDespacho = 1;
                        } else {
                            this.numFolioDespacho = data + 1;
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        RemoverArticuloDetalle() {
            try {
                let data = {
                    id: this.idRemoverArt
                };
                axios
                    .post(
                        this.localVal + "/api/Mantenedor/DeleteArticuloDetalle",
                        data,
                        {
                            headers: {
                                Authorization:
                                    `Bearer ` + sessionStorage.getItem("token")
                            }
                        }
                    )
                    .then(res => {
                        let resp = res.data;
                        if (resp == true) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Completado",
                                text: "Articulo Removido Correctamente",
                                color: "success",
                                position: "top-right"
                            });
                            this.TraerDetalleRecepcion();
                            this.popUpDelArt = false;
                        } else {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No fue posible remover el articulo,intentelo nuevamente",
                                color: "danger",
                                position: "top-right"
                            });
                        }
                    });
            } catch (error) {
                console.log(error);
            }
        },
        ActualizarListado() {
            try {
                let c = this.listaDetalleRecepcion;
                let subtotal = 0;
                c.forEach((value, index) => {
                    subtotal = subtotal + parseInt(value.VALTOT);
                });

                if (subtotal < parseInt(this.dcto)) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text:
                            "El valor del descuento no puede superar el valor NETO",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (subtotal < parseInt(this.cargos)) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text:
                            "El valor del Cargo no puede superar el valor NETO",
                        color: "danger",
                        position: "top-right"
                    });
                } else if (subtotal < parseInt(this.ajustes)) {
                    this.$vs.notify({
                        time: 5000,
                        title: "Error",
                        text:
                            "El valor del Ajuste no puede superar el valor NETO",
                        color: "danger",
                        position: "top-right"
                    });
                } else {
                    subtotal = subtotal - parseInt(this.dcto);
                    subtotal = subtotal + parseInt(this.cargos);
                    subtotal = subtotal + parseInt(this.ajustes);

                    let data = this.listaDetalleRecepcion;
                    let dat = {
                        NUMINT: this.numint,
                        SUBTOTAL: subtotal,
                        DCTO: parseInt(this.dcto),
                        CARGO: parseInt(this.cargos),
                        AJUSTE: parseInt(this.ajustes),
                        OBS: this.Observaciones.toUpperCase(),
                        TIPORD: this.seleccionTipoCompra.NOMTIPCOM
                    };

                    axios
                        .all([
                            axios.post(
                                this.localVal +
                                    "/api/Mantenedor/PutListadoArticulosRecepcion",
                                data,
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            sessionStorage.getItem("token")
                                    }
                                }
                            ),
                            axios.post(
                                this.localVal +
                                    "/api/Mantenedor/PutRecepcionTotal",
                                dat,
                                {
                                    headers: {
                                        Authorization:
                                            `Bearer ` +
                                            sessionStorage.getItem("token")
                                    }
                                }
                            )
                        ])
                        .then(
                            axios.spread((res1, res2) => {
                                let resp1 = res1.data;
                                let resp2 = res2.data;
                                if (resp1 == true && resp2 == true) {
                                    this.$vs.notify({
                                        time: 5000,
                                        title: "Completado",
                                        text:
                                            "Articulos modificados Correctamente",
                                        color: "success",
                                        position: "top-right"
                                    });
                                    this.TraerRecepcion();
                                    this.TraerDetalleRecepcion();
                                } else {
                                    this.$vs.notify({
                                        time: 5000,
                                        title: "Error",
                                        text:
                                            "No fue posible modificar los articulos,intentelo nuevamente",
                                        color: "danger",
                                        position: "top-right"
                                    });
                                }
                            })
                        );
                }
            } catch (error) {
                console.log(error);
            }
        },
        CerrarRecepcion() {
            try {
                this.TraerUltimoNFolioDespacho();
                this.TraerUltimoNInternoDespacho();

                setTimeout(() => {
                    if (this.tiporecepcion == "Consumo Inmediato") {
                        if (this.listaDetalleRecepcion.length < 1) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No existen datos en el detalle de articulos para generar un N° de Folio",
                                color: "danger",
                                position: "top-right"
                            });
                        } else if (this.folio == 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text: "No se pudo generar un N° de Folio",
                                color: "danger",
                                position: "top-right"
                            });
                        } else if (
                            this.nombrearchivo == null ||
                            this.nombrearchivo.length < 1
                        ) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "Debe Ingresar la factura para poder cerrar la recepcion",
                                color: "danger",
                                position: "top-right"
                            });
                        } else {
                            let data = {
                                NUMINT: this.numint,
                                FOLIO: this.folio
                            };

                            let c = this.listaDetalleRecepcion;

                            let d = [];

                            c.forEach((value, index) => {
                                value.FOLIO = this.numFolioDespacho;
                                value.NUMINT = this.numintDespacho;
                                value.idServicio = this.seleccionServicio.id;
                                value.NUMLIBRO = this.numeroLibroPedido;
                                value.TIPDESP = this.tiporecepcion;
                                d.push(value);
                            });
                            const array = d;

                            let nombreUsuario =
                                sessionStorage.getItem("nombre") +
                                " " +
                                sessionStorage.getItem("apellido");
                            let dataDespacho = {
                                FOLIO: this.numFolioDespacho,
                                NUMINT: this.numintDespacho,
                                FECSYS: moment(
                                    this.fechaSistema,
                                    "DD-MM-YYYY"
                                ).format("YYYY-MM-DD"),
                                FECDES: moment(
                                    this.fechaRecepcion,
                                    "DD-MM-YYYY"
                                ).format("YYYY-MM-DD"),
                                TIPDESP: "Solicitud Pedidos",
                                NUMORD: this.nordencompra.toUpperCase(),
                                NUMRIB: this.nrib,
                                PRODUCTO: this.nombre.toUpperCase(),
                                CODBAR: this.codigoBarra.toUpperCase(),
                                OBS: this.Observaciones.toUpperCase(),
                                USUING: nombreUsuario.toUpperCase(),
                                idServicio: this.seleccionServicio.id,
                                NUMLIBRO: this.numeroLibroPedido,
                                TIPRECEPCION: this.tiporecepcion
                            };

                            axios
                                .all([
                                    axios.post(
                                        this.localVal +
                                            "/api/Mantenedor/PostCerrarRecepcion",
                                        data,
                                        {
                                            headers: {
                                                Authorization:
                                                    `Bearer ` +
                                                    sessionStorage.getItem(
                                                        "token"
                                                    )
                                            }
                                        }
                                    ),
                                    axios.post(
                                        this.localVal +
                                            "/api/Recepcion/PostCerrarRecepcionDespacho",
                                        array,
                                        {
                                            headers: {
                                                Authorization:
                                                    `Bearer ` +
                                                    sessionStorage.getItem(
                                                        "token"
                                                    )
                                            }
                                        }
                                    ),
                                    axios.post(
                                        this.localVal +
                                            "/api/Recepcion/PostCerrarDespacho",
                                        dataDespacho,
                                        {
                                            headers: {
                                                Authorization:
                                                    `Bearer ` +
                                                    sessionStorage.getItem(
                                                        "token"
                                                    )
                                            }
                                        }
                                    )
                                ])
                                .then(
                                    axios.spread((res1, res2, res3) => {
                                        let resp1 = res1.data;
                                        let resp2 = res2.data;
                                        let resp3 = res3.data;
                                        if (
                                            resp1 == true &&
                                            resp2 == true &&
                                            resp3 == true
                                        ) {
                                            this.$vs.notify({
                                                time: 5000,
                                                title: "Completado",
                                                text:
                                                    "Articulos Recepcionado y despachado Correctamente",
                                                color: "success",
                                                position: "top-right"
                                            });
                                            this.$router.push({
                                                name: "ListadoRecepcionCerrada"
                                            });
                                        } else {
                                            this.$vs.notify({
                                                time: 5000,
                                                title: "Error",
                                                text:
                                                    "No fue posible cerrar la recepcion y despacho, intentelo nuevamente",
                                                color: "danger",
                                                position: "top-right"
                                            });
                                        }
                                    })
                                );
                        }
                    } else {
                        if (this.listaDetalleRecepcion.length < 1) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "No existen datos en el detalle de articulos para generar un N° de Folio",
                                color: "danger",
                                position: "top-right"
                            });
                        } else if (
                            this.nombrearchivo == null ||
                            this.nombrearchivo.length < 1
                        ) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text:
                                    "Debe Ingresar la factura para poder cerrar la recepcion",
                                color: "danger",
                                position: "top-right"
                            });
                        } else if (this.folio == 0) {
                            this.$vs.notify({
                                time: 5000,
                                title: "Error",
                                text: "No se pudo generar un N° de Folio",
                                color: "danger",
                                position: "top-right"
                            });
                        } else {
                            let data = {
                                NUMINT: this.numint,
                                FOLIO: this.folio
                            };
                            axios
                                .post(
                                    this.localVal +
                                        "/api/Mantenedor/PostCerrarRecepcion",
                                    data,
                                    {
                                        headers: {
                                            Authorization:
                                                `Bearer ` +
                                                sessionStorage.getItem("token")
                                        }
                                    }
                                )
                                .then(res => {
                                    let data = res.data;
                                    if (data == true) {
                                        this.$vs.notify({
                                            time: 5000,
                                            title: "Finalizado",
                                            text:
                                                "Recepcion Cerrada, sera redirigido al listado de recepciones cerradas",
                                            color: "success",
                                            position: "top-right"
                                        });
                                        this.$router.push({
                                            name: "ListadoRecepcionCerrada"
                                        });
                                    }
                                });
                        }
                    }
                }, 2000);
            } catch (error) {
                console.log(error);
            }
        },
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
        },
        cargarHoras() {
            try {
                let date = moment().endOf("day");
                this.fechaRecepcion = date.format("DD/MM/YYYY").toString();
                this.fechaSistema = date.format("DD/MM/YYYY").toString();
                this.fechaDocumento = date.format("DD/MM/YYYY").toString();
            } catch (error) {
                console.log("No se cargo la ISO hora");
                console.log(error);
            }
        }
    },
    beforeMount() {
        this.RefreshToken();
        this.TraerTipoCompra();
        setTimeout(() => {
            this.TraerServicio();
            this.TraerUltimoNInterno();
            this.TraerUltimoNFolio();
            this.TraerTipoDocumentos();
            this.TraerProveedores();
            this.TraerArticulos();
            this.TraerEstado();
            this.TraerBodega();
            this.TraerZona();
            this.cargarHoras();
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
