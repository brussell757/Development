#function that displays a GUI for the user to select a directory (Step 1)
function Select-Folder {

    Add-Type -AssemblyName System.Windows.Forms

    $FolderBrowser = New-Object System.Windows.Forms.FolderBrowserDialog

    if($FolderBrowser.ShowDialog() -eq 'OK') { #checks for confirmation that the 'OK' button was clicked

        Retrieve-Files -Directory $FolderBrowser.SelectedPath #calls the 'Retrieve-Files'
    }

} 

#function that retrieves all subdirectories and files within the chosen director (Step 2)
function Retrieve-Files([string]$Directory) {
    
    "File names that were changed:"

    $files = Get-ChildItem $Directory -Recurse #gets subdirectories and files 

    foreach($raw_filename in $files) { #loop that runs for each file and subdirectory

        if((Get-Item $raw_filename.FullName) -isnot [System.IO.DirectoryInfo]) { #checks if to verify the item is not a directory

           $file_name = [io.path]::GetFileNameWithoutExtension($raw_filename) #strips the extension off the file

           Check-IllegalCharacters -FileName $file_name -SourcePath $raw_filename.FullName #calls the 'Check-IllegalCharacters function

        }

    }

}

#function that checks a given filename for illegal characters (Setp 3)
function Check-IllegalCharacters([string]$FileName,[string]$SourcePath) {

    $invalid_characters = @('~','#','%','&','{','}','\+') #array of illegal characters 

    for($i = 0; $i -lt $invalid_characters.Count; $i++) { #loop that runs for each element in the 'invalid_characters' array
       

        if($FileName -match $invalid_characters[$i]) { #checks if the given filename contains an invalid character from the above array
            
            $characters_to_replace += $invalid_characters[$i] #array that stores the invalid character(s) found in the filename

        }

    }

    
    if($characters_to_replace -ne $null  -or $FileName.Contains(".")) { #checks if the given filename has an array of invalid characters that is not empty OR if the filename contains a '.'

        Replace-IllegalCharacters -ReplacementCharacters $characters_to_replace -SourceFile $FileName -SourcePath $SourcePath #calls the 'Replace-IllegalCharacters' function

    }

}
 
#function that will replace illegal characters found in a given filename (Step 4)
function Replace-IllegalCharacters([char[]]$ReplacementCharacters,[string]$SourceFile,[string]$SourcePath) {

    $updated_filename = $SourceFile #stores the passed filename to a local variable

    foreach($character in $ReplacementCharacters) { #loop that runs for each invalid character found in the given filename
        
        $updated_filename = $updated_filename -replace $character,'_' #replaces the invalid character in the filename with a '_' and updates the '$updated_filename' variable

    }

    Check-IllegalFormat -SourceFile $updated_filename -SourcePath $SourcePath #calls the 'Check-IllegalFormat' function

}

#function that checks for any illegal formatting in the filename (ie. Filename begins/ends with a '.' OR Filename contains consecutive '.' within it) (Step 5)
function Check-IllegalFormat([string]$SourceFile,[string]$SourcePath) {

    $string_characters = $SourceFile.ToCharArray(); #converts the filename into an array of characters
    
    $my_list = [System.Collections.ArrayList]$string_characters #converts the previously assigned array '$string_characters' into an array list
    
    for($i = 0; $i -lt $my_list.Count; $i++) { #loop that runs until the end of an item within the array list is reached

        if($my_list[$i] -eq $my_list[$i+1]) { #checks if a given character in the array list item is equal to the previous character in the array list item

            if($my_list[$i] -eq '.' -and $my_list[$i+1] -eq '.') { #checks if the matching character is a '.'

                $my_list.RemoveAt($i+1) #removes the '.' from the array list item
                
                $i  = $i - 1 #resets the counter back to its previous position for the purposes of checking for consecutive '.'s again once the array list has removed it's given '.'
            }

        }

    }

    $formated_filename = $my_list -join "" #joins the characters in the array list item together on one line

    $formated_filename = $formated_filename.ToString() #converts the array list item to a string
   

    if($formated_filename.StartsWith('.') -or $formated_filename.EndsWith('.')) { #checks if the newly converted filename begins/ends with a '.'
        
        $formated_filename = $formated_filename.Trim(".") #strips the '.' from the filename
        
    }

    Rename-File -RenamedFile $formated_filename -SourcePath $SourcePath #calls the 'Rename-File' function

}

#function that retrieves a given file's extension (Step 6)
function Get-Extension([string]$FullFileName) {

    [System.IO.Path]::GetExtension($FullFileName) #gets the file extension of a given file

}

#function that renames the file containing illegal characters (Step 7)
function Rename-File([string]$RenamedFile,[string]$SourcePath) {

    $extension = Get-Extension -FullFileName $raw_filename #stores the extension of a given file (which was obtained by calling the 'Get-Extension' function) to the '$extension' variable 

    $RenamedFile = $RenamedFile + $extension #updates the '$RenamedFile' variable to contain the retreived file extension

    $pos = $SourcePath.LastIndexOf("\") #gets the last instance of '\' to specify the starting point of the filename

    $SourcePathExists = $SourcePath.Trim($SourcePath.Substring($pos + 1)) #trims the filename from the path

    $SourcePathExists = $SourcePathExists + $RenamedFile #appends the new filename to the path
     
    if(!(Test-Path -Path $SourcePathExists)) { #checks to make sure the newly created filename does not exist

        
        Write-Host $SourcePath.Substring($pos + 1) "--------" $RenamedFile #displays the orginal/new filename if it was changed

        Rename-Item $SourcePath $RenamedFile #renames the file to a format that is ready to be merged into SharePoint

    }

}
