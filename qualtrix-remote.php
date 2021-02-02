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
    
    var learningOutcomes = JSON.parse(getParameterByName('learningOutcomes'));
    
    if ( learningOutcomes !== null ) {
        if (learningOutcomes.length > 0 ) {
            for (i = 0; i < learningOutcomes.length; i++) {
                console.log(learningOutcomes[i]);
            }
        }
    }
}

//////////////////////////////////
//
// END OF COMMON FUNCTIONS
//
//////////////////////////////////

    moduleData_json = getParameterByName('moduleData');

    if ( isValidJson(moduleData_json) ) {
        
        var moduleData = JSON.parse(moduleData_json);
    
        if ( moduleData !== null ) {
        
            if (moduleData.moduleTitle !== null) {
                console.log('Module Title = ' + moduleData.moduleTitle);
            } else {
                console.log('Module Title is empty');
            }
        
            if (moduleData.subjectSpecificSkills !== null) {
                console.log('Subject Specific Skills = ' + moduleData    .subjectSpecificSkills);
            } else {
                console.log('Subject Specific Skills');
            }
                
            if (moduleData.learningOutcomes !== null && moduleData.learningOutcomes.length > 0) {
                console.log('Learning Outcomes - ');
                for (i = 0; i < moduleData.learningOutcomes.length; i++) {
                    console.log(moduleData.learningOutcomes[i]);
                }
            } else {
                console.log('Learning Outcomes is empty');
            }
        }
    } else {
        console.log('Malformed JSON string passed, cannot process!');
    }


</script>