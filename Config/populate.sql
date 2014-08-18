CREATE TABLE IF NOT EXISTS `wwwsqldesigner` (
  `keyword` varchar(30) NOT NULL default '',
  `data` text,
  `dt` timestamp ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY  (`keyword`)
);

CREATE TABLE IF NOT EXISTS `empresa_tipobalanco` (
  `cod` int(3) NOT NULL AUTO_INCREMENT,
  `dstipo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`cod`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

INSERT INTO `empresa_tipobalanco` (`cod`, `dstipo`) VALUES
(2, 'Balanço Patrimonial - Ativo'),
(3, 'Balanço Patrimonial - Passivo'),
(4, 'Demonstração do Resultado do Exercício - DRE'),
(5, 'Demonstração do Resultado Abrangente - DRA'),
(6, 'Demonstração das Origens e Aplicações de Recursos '),
(7, 'Demonstração do Fluxo de Caixa - DFC'),
(8, 'Demonstração do Valor Adicionado - DVA'),
(9, 'Demonstrações das Mutações do Patrimônio Líquido');

