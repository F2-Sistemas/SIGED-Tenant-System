export const conformParaph = (text, classConformTagList = {}, returnInnerHTML = false) => {
    classConformTagList = classConformTagList || {};
    let p = document.createElement('p')
    p.innerHTML = text;

    if (!Object.keys(classConformTagList).length) {
        return returnInnerHTML ? p.innerHTML : p;
    }

    Object.keys(classConformTagList).forEach(tag => {
        let conform = classConformTagList[tag];

        p.querySelectorAll(tag).forEach(child => {
            Object.keys(conform).forEach(method => {
                let methodValue = conform[method];
                child[method] = methodValue;
            })
        })
    })

    return returnInnerHTML ? p.innerHTML : p;
}

const HTMLHelpers = {
    conformParaph: conformParaph,
}

export default HTMLHelpers
