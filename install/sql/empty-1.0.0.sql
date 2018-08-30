-- --------------------------------------------------------
-- Structure de la table 'glpi_plugin_groupassignment_profilegroups'
-- --------------------------------------------------------
DROP TABLE IF EXISTS `glpi_plugin_groupassignment_profilegroups`;
CREATE TABLE `glpi_plugin_groupassignment_profilegroups` (
   `id` int(11) NOT NULL auto_increment,
   `profiles_id` int(11) NOT NULL default '0' COMMENT 'RELATION to glpi_profiles (id)',
   `groups_id` int(11) NOT NULL default '0' COMMENT 'RELATION to glpi_groups (id)',
   PRIMARY KEY  (`id`),
   FOREIGN KEY (`profiles_id`) REFERENCES glpi_profiles(id),
   FOREIGN KEY (`groups_id`) REFERENCES glpi_groups(id)
 ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

