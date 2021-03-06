define({ "api": [
  {
    "type": "get",
    "url": "/api/v1/ddjj",
    "title": "",
    "name": "GetDDJJ",
    "group": "Declaraciones_Juaradas",
    "version": "1.1.0",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "x-sima-api-client",
            "optional": false,
            "field": "Email",
            "description": "<p>del usuario autorizado.</p>"
          },
          {
            "group": "Header",
            "type": "x-sima-api-key",
            "optional": false,
            "field": "API",
            "description": "<p>Key del usuario autorizado.</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "codigo",
            "description": "<p>código del pozo</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "mes",
            "description": "<p>mes de la declaración jurada</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "anio",
            "description": "<p>año de la declaración jurada</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "cuenca",
            "description": "<p>nombre de la cuenca</p>"
          },
          {
            "group": "Parameter",
            "type": "string",
            "optional": true,
            "field": "yacimiento",
            "description": "<p>nombre del yacimiento</p>"
          },
          {
            "group": "Parameter",
            "type": "integer",
            "optional": true,
            "field": "id_pozo",
            "description": "<p>id único identificatorio del pozo</p>"
          }
        ]
      }
    },
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "boolean",
            "optional": false,
            "field": "success",
            "description": "<p>true</p>"
          },
          {
            "group": "Success 200",
            "type": "string",
            "optional": false,
            "field": "message",
            "description": "<p>mensaje de respuesta</p>"
          },
          {
            "group": "Success 200",
            "type": "json",
            "optional": false,
            "field": "data",
            "description": "<p>colección de datos de respuesta</p>"
          }
        ]
      }
    },
    "error": {
      "fields": {
        "401": [
          {
            "group": "401",
            "type": "boolean",
            "optional": false,
            "field": "success",
            "description": "<p>false</p>"
          },
          {
            "group": "401",
            "type": "string",
            "optional": false,
            "field": "message",
            "description": "<p>mensaje de respuesta</p>"
          }
        ]
      }
    },
    "filename": "C:/proyectos/id/sima/enerapi.com/app/Api/V1/Controllers/DatoDdjjController.php",
    "groupTitle": "Declaraciones_Juaradas"
  }
] });
