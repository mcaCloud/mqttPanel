<!-- Cuando hacemos un cambio en la base de datos necesitamos correr una nueva migracion
	No se puede correr la misma migracion para hacer cambios en la base de datos. SUCKS
	Para ello utilizamos la siguente formula para generar una nueva migracion hacia una tabla ya existente

	php artisan make:migration add_*****_to_****_table --table=****

	Los ateriscos representan la informacion que debe de ser cambiada
	Lo ideal es realizar el cambio en la migracion principal
-->

<!-- Cuando se crean Foreing Keys es importante que las dos tablas haga referencia al mismo engine
	
	MyIsaam NO soporta Foreing Keys
	InnoDB SI soporta Foreing keys

	Si una de las dos es MyIsaam no va a funcionar y tira un error
-->
