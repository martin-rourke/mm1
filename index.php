<script type="text/JavaScript">  
    
//////////////////////////////////
//
// START OF COMMON FUNCTIONS
//
//////////////////////////////////

function getParameterByName(name, url = window.location.href) {
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

Storage.prototype.setObj = function(key, obj) {
    return this.setItem(key, JSON.stringify(obj))
}
Storage.prototype.getObj = function(key) {
    return JSON.parse(this.getItem(key))
}

function isValidJson(json) {
    try {
        JSON.parse(json);
        return true;
    } catch (e) {
        return false;
    }
}

function showLocalStorage() {

    console.log('showLocalStorage - helper function');
    
    var LearningOutcomes = localStorage.getObj('LearningOutcomes');
    
    if ( LearningOutcomes !== null && LearningOutcomes.length > 0 ) {
        for (i=0; i<LearningOutcomes.length; i++ ) {
            console.log (LearningOutcomes[i]);
        }
    }           
}

function showSessionStorage() {

    console.log('showSessionStorage - helper function');
    
    var LearningOutcomes = sessionStorage.getObj('LearningOutcomes');
    
    if ( LearningOutcomes !== null && LearningOutcomes.length > 0 ) {
        for (i=0; i<LearningOutcomes.length; i++ ) {
            console.log (LearningOutcomes[i]);
        }
    }           
}

function showGETString() {

    console.log('showGETString - helper function');
    
    var success = true;
    
    var getLearningOutcomes = getParameterByName('learningOutcomes');
    
    if (isValidJson(getLearningOutcomes) ) {
        var learningOutcomes = JSON.parse();
        
        if ( learningOutcomes !== null ) {
            if (learningOutcomes.length > 0 ) {
                for (i = 0; i < learningOutcomes.length; i++) {
                    console.log(learningOutcomes[i]);
                }
            }
        }
    } else {
        success = false;
    }
    
}

//////////////////////////////////
//
// END OF COMMON FUNCTIONS
//
//////////////////////////////////






function processModule( id, revisionId ) {

    console.log('processModule - 2nd API call to get course detail');
    
//console.log(query_string);    
    var query_string = 'https://moduleapproval.warwick.ac.uk/api/v1/modules/' + id + '/revisions/' + revisionId;
    // override quesry string
    query_string = 'api2.php';
    
    console.log('processModule - query string called - ' + query_string);
    
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {

            console.log('processModule, response received -');
            //console.log(JSON.parse(this.responseText));exit();
            
            var response = JSON.parse(this.responseText);

            if ( response.success ) {
                //localStorage.setObj('LearningOutcomes', response.data.fields['ModuleDescription.LearningOutcomes']);
                //sessionStorage.setObj('LearningOutcomes', response.data.fields['ModuleDescription.LearningOutcomes']);
            
                var moduleData = {
                    moduleTitle: response.data.fields['BasicModuleDetails.ModuleTitle'],
                    learningOutcomes: response.data.fields['ModuleDescription.LearningOutcomes'],
                    subjectSpecificSkills: response.data.fields['SkillsCompetenciesAttributes.SubjectSpecificSkills']
                }
                
                //////////////////////////////////
                //
                // only after 2nd API call has returned with success do we want to redirect, we can do this now
                //
                //////////////////////////////////

                // redirect to qualtrix page

// Example call https://www.webanddata.co.uk/mm1/index.php?course_code=ES9H5-10
                //window.location.replace("qualtrix.php");            
                //window.location.replace("http://www.meros.co.uk/mm1");  
                //window.location.replace("qualtrix.php?moduleData=" + JSON.stringify(moduleData));  
                
                query_field_data = JSON.stringify(moduleData);
                
                //console.log(query_field_data.substring(0,(query_field_data.length - 20)) );
                
                window.location.replace("http://www.meros.co.uk/mm1?moduleData=" + query_field_data );  

                //showLocalStorage( );
                //showSessionStorage( );

            }             
        }
    }
    xhttp.open("GET", query_string, true);
    xhttp.send();
}

function processRequest( module_reference ) {

    console.log('processRequest - 1st API call to get list of courses');
    
    // remove old keys
    delete localStorage.LearningOutcomes;
    delete sessionStorage.LearningOutcomes;

    // now go get all modules data
    var query_string = 'https://moduleapproval.warwick.ac.uk/api/v3/modules';
    query_string = 'api1.php';
    
    console.log('processRequest - query string called - ' + query_string);

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        
        if (this.readyState == 4 && this.status == 200) {
            
            console.log('processRequest, response received');
            //console.log(JSON.parse(this.responseText));
            
            var response = JSON.parse(this.responseText);

            //console.log (response.data.modules);
     
            if ( response.success ) {
            
                if ( response.data.modules !== null ) {
                    for ( i=0; i<response.data.modules.length; i++ ) {
//console.log(response.data.modules[i]);                    
                        // process modules list and look for matching module reference
                        if ( response.data.modules[i].reference == module_reference ) {
                        
                            var id = response.data.modules[i].id;
                            var revisionId = response.data.modules[i].revisionId;

                            console.log('processRequest, module details found, querystring = api/v1/modules/' + id + '/revisions/' + revisionId);
                            processModule('api/v1/modules/' + id + '/revisions/' + revisionId);
                            
                            break;
                        }
                    }  
                }
            }
        }
  };
  xhttp.open("GET", query_string, true);
  xhttp.send();
}


//  Process parameter in URL - this is the code that will run on WU Sitebuilder
// Example call https://www.webanddata.co.uk/mm1/index.php?course_code=ES9H5-10

processRequest( getParameterByName('course_code') );

</script>