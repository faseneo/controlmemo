<?php 
#Crear tablas con defincion de constantes

# tabla constantes historial (bitacora insercion, modificacion o elimacion) 
define( 'NORMAL_TYPE', 0 );
define( 'NEW_BUG', 1 );
define( 'BUGNOTE_ADDED', 2 );
define( 'BUGNOTE_UPDATED', 3 );
define( 'BUGNOTE_DELETED', 4 );
define( 'DESCRIPTION_UPDATED', 6 );
define( 'ADDITIONAL_INFO_UPDATED', 7 );
define( 'STEP_TO_REPRODUCE_UPDATED', 8 );
define( 'FILE_ADDED', 9 );
define( 'FILE_DELETED', 10 );
define( 'BUGNOTE_STATE_CHANGED', 11 );
define( 'BUG_MONITOR', 12 );
define( 'BUG_UNMONITOR', 13 );
define( 'BUG_DELETED', 14 );
define( 'BUG_ADD_SPONSORSHIP', 15 );
define( 'BUG_UPDATE_SPONSORSHIP', 16 );
define( 'BUG_DELETE_SPONSORSHIP', 17 );
define( 'BUG_ADD_RELATIONSHIP', 18 );
define( 'BUG_DEL_RELATIONSHIP', 19 );
define( 'BUG_CLONED_TO', 20 );
define( 'BUG_CREATED_FROM', 21 );
define( 'BUG_REPLACE_RELATIONSHIP', 23 );
define( 'BUG_PAID_SPONSORSHIP', 24 );
define( 'TAG_ATTACHED', 25 );
define( 'TAG_DETACHED', 26 );
define( 'TAG_RENAMED', 27 );
define( 'BUG_REVISION_DROPPED', 28 );
define( 'BUGNOTE_REVISION_DROPPED', 29 );
define( 'PLUGIN_HISTORY', 100 );

# tabla constantes de relacion entre memos
define( 'BUG_REL_NONE', -2 );
define( 'BUG_REL_ANY', -1 );
define( 'BUG_DUPLICATE', 0 );
define( 'BUG_RELATED', 1 );
define( 'BUG_DEPENDANT', 2 );
define( 'BUG_BLOCKS', 3 );
define( 'BUG_HAS_DUPLICATE', 4 );

# tabla constantes de estados de memos

# tabla constantes de estados de detalles del memo

# tabla constantes de limites de tiempo para alertas

# tabla constantes de prioridad
define( 'ninguna', 10 );
define( 'baja', 20 );
define( 'normal', 30 );
define( 'alta', 40 );
define( 'urgente', 50 );
define( 'inmediata', 60 );
