[![CodeQL](https://github.com/ChrisK106/duolab/actions/workflows/codeql.yml/badge.svg?branch=master)](https://github.com/ChrisK106/duolab/actions/workflows/codeql.yml)

# ![DUOLAB Logo](docs/duolab_logo.png)
**DUOLAB** es un modesto **sistema web** para gestión de clientes, productos, ventas y más...
Escrito utilizando **PHP** y **JavaScript**.

## Módulos disponibles
- Clientes
- Almacén (Maestro de Productos, Registro e Historial de Movimientos)
- Ventas (Cotización, Factura, Boleta, Nota de Crédito)
- Compras / Servicios (Orden de Compra, Orden de Servicio, Compra Interna)
- Proveedores
- Empleados
- Usuarios (Registro y Gestión de Accesos)
- Reportes (Clientes, Productos, Ventas, Gastos)

## Instalación
Puedes revisar el archivo *[manual de instalación](https://github.com/ChrisK106/duolab/blob/master/docs/duolab_manual_de_instalacion.pdf)* que se encuentra dentro de la carpeta *docs* del repositorio.
Este te servirá como guía para realizar la instalación de **XAMPP**, una solución open source de servidor web **Apache** con soporte para aplicaciones **PHP** más un gestor de base de datos SQL **MariaDB**.
También encontrarás instrucciones para realizar la instalación del script *db_duolab.sql* utilizando **phpMyAdmin**.
Así como pasos para la instalación, configuración del sitio web y las credenciales por defecto del usuario administrador del sitio.

## Capturas
![DUOLAB Login](docs/preview/duolab_login.png)
![DUOLAB Home](docs/preview/duolab_home.png)
![DUOLAB Home Dark](docs/preview/duolab_home_dark.png)
![DUOLAB Registro de Cliente](docs/preview/duolab_registro_cliente.png)
![DUOLAB Lista de Productos](docs/preview/duolab_lista_productos.png)
![DUOLAB Registro de Factura](docs/preview/duolab_registro_factura.png)
![DUOLAB Reporte de Ventas por Cliente](docs/preview/duolab_reporte_ventas_cliente.png)
![DUOLAB Reporte Top 20 de Productos](docs/preview/duolab_reporte_productos_top20.png)
![DUOLAB Gráfico de Ventas por Periodo](docs/preview/duolab_grafico_ventas_por_periodo.png)

## Dependencias
- [AdminLTE](https://github.com/ColorlibHQ/AdminLTE)
- [jQuery](https://github.com/jquery/jquery)
- [DataTables](https://github.com/DataTables/DataTablesSrc)
- [Select2](https://github.com/select2/select2)
- [FPDF](http://www.fpdf.org)
- [Notify.js](https://github.com/jpillora/notifyjs)
