-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-11-2021 a las 00:35:34
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `asimet_encuestas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `rif` varchar(20) NOT NULL,
  `id_rubro` int(11) NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `estatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`id`, `nombre`, `rif`, `id_rubro`, `fecha_registro`, `estatus`) VALUES
(1, 'Marna Garage', 'J-306709517', 5, '2021-10-10 09:55:27', 1),
(2, 'Cervecería Polar C.A.', 'J-000063729', 4, '2021-10-11 17:44:32', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuesta`
--

CREATE TABLE `encuesta` (
  `id` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `id_representante` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nivel`
--

CREATE TABLE `nivel` (
  `id` int(11) NOT NULL,
  `titulo` varchar(30) NOT NULL,
  `descripcion` text NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `nivel`
--

INSERT INTO `nivel` (`id`, `titulo`, `descripcion`, `estatus`) VALUES
(1, 'Básico', 'Empresas que tienen algunas iniciativas de proyectos digitales, pero en formas diferentes (no estandarizadas), independientes de cada departamento y en formas dispersas en la compañía', 1),
(2, 'Principiante', 'Empresas que comienzan a formalizar algún plan de transformación digital en alguna área concreta de la compañía', 1),
(3, 'Transicional', 'Empresas que están trabajando claramente en la hoja de ruta de Transformación Digital, de forma integrada a todas las áreas de la organización', 1),
(4, 'Avanzado', 'Empresas que se encuentran implementando un plan de Transformación Digital en varios frentes de la organización, con asignación de líderes de proyectos digitales en posiciones claves', 1),
(5, 'Evolucionado', 'Empresas que ya han desarrollado su negocio en base a una Transformación Digital. Organizaciones innovadoras, ágiles, flexibles, conectadas con sus clientes, colaborativas y abiertas que se adaptan continuamente a los cambios', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opcion`
--

CREATE TABLE `opcion` (
  `id` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `id_nivel` int(11) NOT NULL,
  `id_pilar` int(11) NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `opcion`
--

INSERT INTO `opcion` (`id`, `descripcion`, `id_nivel`, `id_pilar`, `estatus`) VALUES
(1, 'Muy poca participación de los Ejecutivos y directores para implementar estrategias y soluciones digitales', 1, 1, 1),
(2, 'Aunque tenemos un sitio web, no existe una estrategia digital departamental o de la compañía', 1, 1, 1),
(3, 'Aunque existe una propuesta de valor con transformación digital, esta no es conocida o aún no desarrollada', 1, 1, 1),
(4, 'Las oportunidades digitales no se entienden ni tampoco se han definido', 1, 1, 1),
(5, 'Existen algunos proyectos digitales ad hoc iniciados por grupos internos y particulares, pero en forma aislada', 1, 1, 1),
(6, 'El Directorio o Gerente General no ha permitido una presencia en redes sociales o un compromiso de mayor interacción (o contacto) digital con los clientes', 1, 1, 1),
(7, 'La propuesta de valor de una estrategia digital comienza a ser conocida por el Directorio, Gerente General y Ejecutivos', 2, 1, 1),
(8, 'Se está explorando el impacto de la innovación y las tecnologías emergentes en el negocio actual', 2, 1, 1),
(9, 'Existe alguna colaboración en forma excepcional con otros departamentos, en relación a la prestación de servicios digitales', 2, 1, 1),
(10, 'Los canales digitales y las redes sociales son monitoreados, pero estas aún son vistas más como un riesgo que como una oportunidad para la compañía', 2, 1, 1),
(11, 'Existe una estrategia Digital conocida por la organización', 3, 1, 1),
(12, 'Los roles y responsabilidades para entregar la estrategia digital están claros y entendidos por los miembros de la organización', 3, 1, 1),
(13, 'Los beneficios de la estrategia digital están bien definidos y entendidos por la organización', 3, 1, 1),
(14, 'Existen alianzas estratégicas digitales con otros departamentos de la organización', 3, 1, 1),
(15, 'Empresa se encuentra enfocada al cliente y sus necesidades, utilizando para ello tecnologías emergentes', 3, 1, 1),
(16, 'Hay un compromiso proactivo con los clientes en todos los canales digitales', 3, 1, 1),
(17, 'Se entienden los beneficios de las redes sociales e impulsan las actividades en ellas', 3, 1, 1),
(18, 'La estrategia digital se integra en el proceso de planificación de cada división e influye en la estrategia y la dirección general de la organización', 4, 1, 1),
(19, 'Los beneficios están bien definidos, se entienden e impulsan toda la actividad digital', 4, 1, 1),
(20, 'Un completo entendimiento de los KPIs digitales, los beneficios que estos tienen para el negocio y los clientes, y están siendo monitoreados y reportados', 4, 1, 1),
(21, 'Perfecta experiencia de los clientes en todos los canales, tanto digital y no digital', 4, 1, 1),
(22, 'Colaboración estratégica entre los departamentos de la organización, utilizando múltiples canales', 4, 1, 1),
(23, 'La estrategia digital está integrada y es indistinguible de la visión y la estrategia de la organización', 4, 1, 1),
(24, 'El directorio y Gerente General (Ejecutivos de 1ª línea) entienden e impulsan completamente los canales digitales, dando el ejemplo en su utilización', 5, 1, 1),
(25, 'Los nuevos servicios y productos nacen en formato digital inmediatamente', 5, 1, 1),
(26, 'Se realiza un rediseño de los servicios y productos no digitales, de manera que renacen como digitales', 5, 1, 1),
(27, 'Los servicios y canales digitales impulsan la estructura organizativa y los informes de reporte', 5, 1, 1),
(28, 'Se percibe una presión de parte del personal de la organización para lograr tener una cultura digital en la empresa', 1, 2, 1),
(29, 'Muy poco deseo en la organización por impulsar la prestación de servicios digitales', 1, 2, 1),
(30, 'Existe alto grado de aversión al riesgo en temas digitales y resistencia al cambio cultural', 1, 2, 1),
(31, 'Limitado o casi nulo intento por entender las necesidades de los clientes', 1, 2, 1),
(32, 'Hay miedo de comprometerse con la utilización de las redes sociales y/o permitir su uso por parte del personal', 1, 2, 1),
(33, 'Un pequeño número de empleados se sienten comprometidos en apoyar los proyectos digitales de la compañía', 2, 2, 1),
(34, 'Existe alguna conciencia de oportunidades digitales entre las divisiones de la organización', 2, 2, 1),
(35, 'Hay mayor tolerancia a aceptar el riesgo de proyectos digitales en la organización', 2, 2, 1),
(36, 'Solo existe un compromiso de las redes sociales restringido a escuchar y no a interactuar con los clientes', 2, 2, 1),
(37, 'Existe una estrategia de gestión del cambio al desarrollo de la cultura digital en la organización', 2, 2, 1),
(38, 'Hay indicios de una mayor interacción entre los departamentos internos de la compañía, mejorando las prácticas colaborativas entre ellos', 2, 2, 1),
(39, 'Existe una estrategia digital desarrollada y adoptada por el personal de la organización', 3, 2, 1),
(40, 'Equipos de proyectos digitales integrados en la estructura organizacional', 3, 2, 1),
(41, 'El personal comprende los beneficios y oportunidades, tanto para ellos como para los clientes, de la estrategia digital de la compañía', 3, 2, 1),
(42, 'Tanto el personal como los procesos digitalizados se enfocan en la satisfacción del cliente', 3, 2, 1),
(43, 'Existe un plan de gestión de cambio hacia la transformación digital que se está implementando y monitoreando', 3, 2, 1),
(44, 'Todo el personal de la organización adopta plenamente la estrategia digital y están impulsando el cambio cultural', 4, 2, 1),
(45, 'Se adoptó una sólida cultura centrada en el cliente y su mejora continua', 4, 2, 1),
(46, 'El personal organizado en equipos con foco en la detección de las necesidades de los clientes en lugar de los servicios y productos de la organización', 4, 2, 1),
(47, 'El personal redefine sus roles y KPI personales de acuerdo con la estrategia digital y los KPI organizacionales', 4, 2, 1),
(48, 'Todo el personal es digitalmente inteligente y consciente en forma individual; consideran que el tener un equipo digital ya es definido como obsoleto', 5, 2, 1),
(49, 'La cultura digital está integrada en la cultura corporativa general y se supervisa, mejora y perfecciona constantemente', 5, 2, 1),
(50, 'Se alienta la retroalimentación digital de los clientes y el personal, aplicando las lecciones aprendidas', 5, 2, 1),
(51, 'El personal explora y genera de forma proactiva formas de mejorar la prestación de servicios digitales y la productividad interna, a través de soluciones digitales', 5, 2, 1),
(52, 'Existe poco interés por desarrollar y documentar políticas y procedimientos en forma digital en la compañía', 1, 3, 1),
(53, 'Existe muy poca o ninguna asignación de presupuesto a la transformación digital de los procesos', 1, 3, 1),
(54, 'El personal tiene acceso limitado a las plataformas web y de redes digitales sociales en el trabajo', 1, 3, 1),
(55, 'No hay un plan de capacitación para el personal en el uso de herramientas y canales digitales en beneficio de la compañía', 1, 3, 1),
(56, 'No se percibe un intento de rediseñar la prestación de servicios, así como las prácticas comerciales, para aprovechar la eficiencia de los servicios digitales', 1, 3, 1),
(57, 'Solo algunos procesos digitales se encuentran desarrollados y documentados', 2, 3, 1),
(58, 'Se avanza lentamente hacia la definición de capacidades organizacionales digitales', 2, 3, 1),
(59, 'Existe conocimiento limitado de los beneficios del canal digital para el personal y los clientes de la organización', 2, 3, 1),
(60, 'Los riesgos y desafíos del compromiso digital no se encuentran identificados', 2, 3, 1),
(61, 'Solo se ha brindado capacitación al personal sobre el uso de los canales digitales y las redes sociales de la organización', 2, 3, 1),
(62, 'Se han identificado y desarrollado políticas y procedimientos críticos del negocio para la transformación digital', 3, 3, 1),
(63, 'Políticas y procedimientos digitales regularmente auditados y mejorados', 3, 3, 1),
(64, 'Presupuesto para transformación digital adecuado y acorde a las necesidades', 3, 3, 1),
(65, 'Se identifican y buscan los beneficios de la productividad del personal y los beneficios de adoptar soluciones digitales', 3, 3, 1),
(66, 'Plan de formación del personal que se enfoca en ayudar a mejorar la presencia en línea y la prestación de servicios a sus clientes', 3, 3, 1),
(67, 'Todas las políticas y procedimientos para la transformación digital son de forma integral y han sido identificados y desarrollados', 4, 3, 1),
(68, 'El personal posee la capacitación y los recursos para cumplir con sus funciones y responsabilidades asignadas para implementar la estrategia digital', 4, 3, 1),
(69, 'La transformación digital está totalmente integrada en los planes organizacionales y al ciclo de revisión de negocios', 4, 3, 1),
(70, 'Todos los recursos digitales y la capacitación del personal se centran en gestionar las necesidades de los clientes', 4, 3, 1),
(71, 'Todas las políticas digitales, procedimientos y actividades digitales están implementadas y son fundamentales para la actividad comercial diaria de la empresa', 5, 3, 1),
(72, 'Las políticas y procedimientos son constantemente revisados y optimizados', 5, 3, 1),
(73, 'La capacitación del personal respalda la estrategia digital actual y anticipa los requisitos futuros de habilidades y conocimientos', 5, 3, 1),
(74, 'Los recursos y presupuestos son adecuados para el soporte de los canales digitales, con relación a las actividades operacionales y la prestación de servicios', 5, 3, 1),
(75, 'El personal dispone de los recursos necesarios para anticipar y responder a nuevas tecnologías e innovación digital futura', 5, 3, 1),
(76, 'Existe nulo intento por parte de la Dirección de considerar las soluciones digitales como una transformación que permita beneficiar a la organización', 1, 4, 1),
(77, 'Hay poca experimentación e inquietud, respecto a potenciar la mejora de los métodos actuales de prestación de servicios y de relacionarse con los clientes de forma digital', 1, 4, 1),
(78, 'Los posibles procesos de negocios que son fáciles y rentables de entregar en línea, se están pensando digitalizar', 2, 4, 1),
(79, 'Los proyectos digitales siguen centrados en la organización y no en las necesidades del cliente', 2, 4, 1),
(80, 'Se está analizado la posibilidad de utilizar ciertos canales digitales para cambiar los métodos de prestación de servicios actuales, solo para algunos casos especiales', 2, 4, 1),
(81, 'Todas las prácticas y procesos comerciales se están revisando y priorizando para la conversión a canales digitales', 3, 4, 1),
(82, 'Se explora el posible potencial de los canales digitales para crear nuevas formas de relacionarse con los clientes y brindar servicios', 3, 4, 1),
(83, 'Los canales digitales se consideran como una posibilidad concreta para crear nuevas relaciones con los clientes', 3, 4, 1),
(84, 'La innovación en la prestación de servicios digitales y productos, es impulsada por las necesidades y expectativas de los clientes: nuevos servicios, nuevos productos, nuevas relaciones', 4, 4, 1),
(85, 'Toda la organización fomenta la experimentación y uso de todos los servicios digitales con que se cuenta', 4, 4, 1),
(86, 'Constantemente se analizan y crean nuevos métodos de desarrollo de servicios digitales que sean apropiados para la naturaleza dinámica del negocio', 4, 4, 1),
(87, 'Toda la organización busca formas de utilizar los canales y tecnologías digitales para redefinir el servicio al cliente y así generar nuevos beneficios', 5, 4, 1),
(88, 'Aparecen nuevas prácticas de gestión y estructuras organizativas para alinearse con la organización digital', 5, 4, 1),
(89, 'Es una práctica común el imaginar las necesidades y tecnologías futuras, se explora y experimenta con métodos y soluciones', 5, 4, 1),
(90, 'Muy bajo o inexistente compromiso de TI con la transformación digital de la empresa y soluciones digitales a los clientes', 1, 5, 1),
(91, 'No hay una estrategia de TI, o está mal diseñada para los requerimientos actuales de transformación digital', 1, 5, 1),
(92, 'No existe integración de los canales digitales con los procesos o sistemas del negocio', 1, 5, 1),
(93, 'No hay integración con la estrategia de comunicaciones', 1, 5, 1),
(94, 'Existe un soporte informático básico para la estrategia digital', 2, 5, 1),
(95, 'El enfoque está en las soluciones de TI para el propio departamento, no en la transformación digital y las necesidades de los clientes', 2, 5, 1),
(96, 'Existe una cierta integración débil de los canales digitales con procesos del negocio, sistemas y estrategia de comunicaciones', 2, 5, 1),
(97, 'La estrategia y los sistemas de TI están alineados con la estrategia digital de la organización', 3, 5, 1),
(98, 'La tecnología de TI se centra en la entrega de canales digitales y en los beneficios articulados que se obtienen de la estrategia digital', 3, 5, 1),
(99, 'Existe una integración de los sistemas de TI que ayudan al desarrollo de servicios y productos, unidos con una visión única al cliente', 3, 5, 1),
(100, 'Los sistemas y soluciones de TI cumplen con las mejores prácticas en seguridad y continuidad empresarial del mercado', 3, 5, 1),
(101, 'La tecnología de TI mejora la entrega de servicios digitales, la velocidad y facilidad para desarrollar nuevos servicios digitales', 4, 5, 1),
(102, 'Los comentarios del equipo de TI garantizan que los servicios digitales respondan a los dispositivos elegidos por los clientes y cumplan con los estándares de accesibilidad que ellos requieren', 4, 5, 1),
(103, 'El equipo de TI proporciona información en forma proactiva para proyectos de digitalización y reingeniería de procesos de negocios', 4, 5, 1),
(104, 'El equipo de TI está capacitado para dar apoyo a otros empleados, en el uso de soluciones y herramientas digitales', 4, 5, 1),
(105, 'La estrategia y el rendimiento del departamento de TI están completamente alineados con la visión y la estrategia de la organización', 5, 5, 1),
(106, 'El departamento de TI optimiza constantemente los beneficios de la prestación de servicios digitales', 5, 5, 1),
(107, 'Los procesos de negocio y los sistemas de TI están determinados por los canales digitales y siempre alineados con satisfacer los requerimientos y necesidades de los clientes', 5, 5, 1),
(108, 'Existe retroalimentación y optimización de procesos de TI y de herramientas digitales en forma continua', 5, 5, 1),
(109, 'Existen pocas o ninguna herramienta para promover la innovación, colaboración y desarrollo de servicios digitales con los clientes', 1, 4, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pilar`
--

CREATE TABLE `pilar` (
  `id` int(11) NOT NULL,
  `titulo` varchar(60) NOT NULL,
  `descripcion` text NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `pilar`
--

INSERT INTO `pilar` (`id`, `titulo`, `descripcion`, `estatus`) VALUES
(1, 'Visión y liderazgo', 'Este pilar representa el apoyo y soporte de la Dirección General, tales como: autorizaciones y procesos de información, y establecimiento en detalle de funciones y responsabilidades en la Organización', 1),
(2, 'Gente y cultura', 'Se refiere a la cultura de la organización, que incluye la centralización en el cliente, la innovación, el apetito por el riesgo y la atención a la gestión del cambio. Especialmente las funciones del personal de la organización', 1),
(3, 'Capacidades Organizacionales y Efectividad', 'La capacidad de ser una organización digital  evolucionada. Los recursos, números de personal y conjuntos de habilidades, así como el acceso a la tecnología es adecuada. Existe un plan de capacitación, políticas y procedimientos de apoyo', 1),
(4, 'Innovación', 'La disposición y la capacidad de imaginar nuevos servicios y productos, así como nuevas formas de prestación de servicios. Alto nivel de proactividad y deseo de evaluar e implementar nuevas tecnologías, procesos de negocios y modos de trabajo', 1),
(5, 'Tecnología', 'La idoneidad de las plataformas tecnológicas de los procesos, así como de los programas y sistemas, soportan los otros cuatro pilares anteriores', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `representante`
--

CREATE TABLE `representante` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `cargo` varchar(50) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `estatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `representante`
--

INSERT INTO `representante` (`id`, `nombre`, `cargo`, `telefono`, `id_usuario`, `id_empresa`, `fecha_registro`, `estatus`) VALUES
(1, 'Nicolle', 'Desarrollador', '04245355063', 2, 1, '2021-10-10 10:00:41', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuesta`
--

CREATE TABLE `respuesta` (
  `id_encuesta` int(11) NOT NULL,
  `id_opcion` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultado`
--

CREATE TABLE `resultado` (
  `id_encuesta` int(11) NOT NULL,
  `id_pilar` int(11) NOT NULL,
  `promedio` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` int(11) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `nombre`, `estatus`) VALUES
(1, 'Superadministrador', 1),
(2, 'Empresa', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rubro`
--

CREATE TABLE `rubro` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rubro`
--

INSERT INTO `rubro` (`id`, `descripcion`, `estatus`) VALUES
(1, 'AGRICULTURA Y PESCA', 1),
(2, 'MINERÍA', 1),
(3, 'INDUSTRIAS METALÚRGICAS METALMECÁNICAS', 1),
(4, 'INDUSTRIAS MANUFACTURERAS', 1),
(5, 'OTRAS INDUSTRIAS', 1),
(6, 'CONSTRUCCIÓN', 1),
(7, 'RETAIL', 1),
(8, 'TURISMO', 1),
(9, 'INSTITUCIONES FINANCIERAS', 1),
(10, 'INSTITUCIONES GUBERNAMENTALES', 1),
(11, 'EDUCACIÓN', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `ultima_conexion` datetime NOT NULL DEFAULT current_timestamp(),
  `estatus` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `email`, `token`, `id_rol`, `fecha_registro`, `ultima_conexion`, `estatus`) VALUES
(1, 'cuestionarios@redpbm.org', 'RedPBM2021.', 1, '2019-07-16 16:37:49', '2019-07-16 16:37:49', 1),
(2, 'nicollevargas07@gmail.com', '03e3cbe005', 2, '2021-10-10 10:00:41', '2021-10-11 16:55:23', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rif` (`rif`),
  ADD KEY `fk_empresa_rubro` (`id_rubro`);

--
-- Indices de la tabla `encuesta`
--
ALTER TABLE `encuesta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_encuesta_representante` (`id_representante`) USING BTREE,
  ADD KEY `token` (`token`);

--
-- Indices de la tabla `nivel`
--
ALTER TABLE `nivel`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `opcion`
--
ALTER TABLE `opcion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_opcion_nivel` (`id_nivel`),
  ADD KEY `fk_opcion_pilar` (`id_pilar`);

--
-- Indices de la tabla `pilar`
--
ALTER TABLE `pilar`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `representante`
--
ALTER TABLE `representante`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_usuario` (`id_usuario`),
  ADD KEY `fk_representante_empresa` (`id_empresa`);

--
-- Indices de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  ADD PRIMARY KEY (`id_encuesta`,`id_opcion`) USING BTREE,
  ADD KEY `fk_respuesta_opcion` (`id_opcion`),
  ADD KEY `fk_respuesta_encuesta` (`id_encuesta`) USING BTREE;

--
-- Indices de la tabla `resultado`
--
ALTER TABLE `resultado`
  ADD PRIMARY KEY (`id_encuesta`,`id_pilar`),
  ADD KEY `fk_resultado_pilar` (`id_pilar`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rubro`
--
ALTER TABLE `rubro`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_usuario_rol` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `encuesta`
--
ALTER TABLE `encuesta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `nivel`
--
ALTER TABLE `nivel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `opcion`
--
ALTER TABLE `opcion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT de la tabla `pilar`
--
ALTER TABLE `pilar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `representante`
--
ALTER TABLE `representante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `rubro`
--
ALTER TABLE `rubro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD CONSTRAINT `fk_empresa_rubro` FOREIGN KEY (`id_rubro`) REFERENCES `rubro` (`id`);

--
-- Filtros para la tabla `encuesta`
--
ALTER TABLE `encuesta`
  ADD CONSTRAINT `fk_encuesta_representante` FOREIGN KEY (`id_representante`) REFERENCES `representante` (`id`);

--
-- Filtros para la tabla `opcion`
--
ALTER TABLE `opcion`
  ADD CONSTRAINT `fk_opcion_nivel` FOREIGN KEY (`id_nivel`) REFERENCES `nivel` (`id`),
  ADD CONSTRAINT `fk_opcion_pilar` FOREIGN KEY (`id_pilar`) REFERENCES `pilar` (`id`);

--
-- Filtros para la tabla `representante`
--
ALTER TABLE `representante`
  ADD CONSTRAINT `fk_representante_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id`),
  ADD CONSTRAINT `fk_representante_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `respuesta`
--
ALTER TABLE `respuesta`
  ADD CONSTRAINT `fk_respuesta_encuesta` FOREIGN KEY (`id_encuesta`) REFERENCES `encuesta` (`id`),
  ADD CONSTRAINT `fk_respuesta_opcion` FOREIGN KEY (`id_opcion`) REFERENCES `opcion` (`id`);

--
-- Filtros para la tabla `resultado`
--
ALTER TABLE `resultado`
  ADD CONSTRAINT `fk_resultado_encuesta` FOREIGN KEY (`id_encuesta`) REFERENCES `encuesta` (`id`),
  ADD CONSTRAINT `fk_resultado_pilar` FOREIGN KEY (`id_pilar`) REFERENCES `pilar` (`id`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_rol` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
