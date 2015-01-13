<?php

/* Configuration */
$sTargetBaseDir		= dirname( dirname( dirname( __FILE__ ) ) );    // the plugin root die.
$sResultFilePath    = $sTargetBaseDir . '/include/include-class-list-boot.php';
$sResultFilePath2   = $sTargetBaseDir . '/include/include-class-list.php';

/* If accessed from a browser, exit. */
$bIsCLI				= php_sapi_name() == 'cli';
$sCarriageReturn	= $bIsCLI ? PHP_EOL : '<br />';
if ( ! $bIsCLI ) { exit; }

/* Include necessary files */
require( dirname( __FILE__ ) . '/class/PHP_Class_Files_Inclusion_List_Creator.php' );

/* Check the permission to write. */
if ( ! file_exists( $sResultFilePath ) ) {
	file_put_contents( $sResultFilePath, '', FILE_APPEND | LOCK_EX );
}
if ( 
	( file_exists( $sResultFilePath ) && ! is_writable( $sResultFilePath ) )
	|| ! is_writable( dirname( $sResultFilePath ) ) 	
) {
	exit( sprintf( 'The permission denied. Make sure if the folder, %1$s, allows to modify/create a file.', dirname( $sResultFilePath ) ) );
}

/* Create a minified version of the framework. */
echo 'Started...' . $sCarriageReturn;
new PHP_Class_Files_Inclusion_Script_Creator(
	$sTargetBaseDir, // the base dir 
	array( $sTargetBaseDir . '/include/class/boot', ), 	// scan directory paths
	$sResultFilePath, 
	array(
		// 'header_class_name'	=>	'ResponsiveColumnWidgets_InclusionClassFilesHeader',
        // 'header_class_path'	=>	$sTargetBaseDir . '/development/document/ResponsiveColumnWidgets_InclusionClassFilesHeader.php',
		'output_buffer'		=>	true,
		// 'header_type'		=>	'CONSTANTS',	
		'exclude_classes'	=>	array( 
            // 'ResponsiveColumnWidgets_MinifiedVersionHeader', 
            // 'ResponsiveColumnWidgets_InclusionClassFilesHeader', 
            // 'admin-page-framework' 
        ),
		'output_var_name'	=>	'$_aClassFiles',
		'base_dir_var'  	=>	'ResponsiveColumnWidgets_Registry::$sDirPath',
		'search'			=>	array(
			'allowed_extensions'	=>	array( 'php' ),	// e.g. array( 'php', 'inc' )
			// 'exclude_dir_paths'		=>	array( $sTargetBaseDir . '/include/class/admin' ),
			'exclude_dir_names'		=>	array( '_document', 'document', ),
			'is_recursive'			=>	true,
		),			
	)
);
new PHP_Class_Files_Inclusion_Script_Creator(
	$sTargetBaseDir,   // the base dir 
	array( $sTargetBaseDir . '/include/class/', ), 	// scan directory paths
	$sResultFilePath2, 
	array(
		// 'header_class_name'	=>	'ResponsiveColumnWidgets_InclusionClassFilesHeader',
        // 'header_class_path'	=>	$sTargetBaseDir . '/development/document/ResponsiveColumnWidgets_InclusionClassFilesHeader.php',
		'output_buffer'		=>	true,
		// 'header_type'		=>	'CONSTANTS',	
		'exclude_classes'	=>	array( 
            // 'ResponsiveColumnWidgets_MinifiedVersionHeader', 
            // 'ResponsiveColumnWidgets_InclusionClassFilesHeader', 
            // 'admin-page-framework' 
        ),
		'base_dir_var'  	=>	'ResponsiveColumnWidgets_Registry::$sDirPath',
		'output_var_name'	=>	'$_aClassFiles',
		'search'			=>	array(
			'allowed_extensions'	=>	array( 'php' ),	// e.g. array( 'php', 'inc' )
			// 'exclude_dir_paths'		=>	array( $sTargetBaseDir . '/include/class/admin' ),
			'exclude_dir_names'		=>	array( 'boot', '_document', 'document', ),
			'is_recursive'			=>	true,
		),			
	)
);
echo 'Done!' . $sCarriageReturn;