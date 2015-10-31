<#
    Script Developer: Brandon Russell
    Company: Cape Henry Associates, Inc.
    Description: This script was designed for the purposes of formatting filenames in a way that prepares them for a merge into SharePoint
                 This script prompts the user to choose a directory
                 This script then obtains all subdirectories/files within the selected directory and searches for any filenames that contain invalid characters and/or illegal formatting
                 This script then renames these improperly named files and replaces the original name with the newly created name
#>

. 'C:\Users\Brandon\Desktop\rename_files_script\functions.ps1' #includes the 'functions.ps1' file

Select-Folder #calls the 'Select-Folder' function in the 'functions.ps1' file

$completion_notice = New-Object -ComObject Wscript.Shell 

$completion_notice.Popup("Process Complete",0,"Summary") #displays a dialog box that lets the user know when the process is complete