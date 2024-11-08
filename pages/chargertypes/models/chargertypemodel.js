export const newChargerModels = () =>{
    const model = {
        _id: "",
        chargerType : ""
    }
    return model;
}

export const chargerModelGrid = () => {
    let xc = [];
    if (useraccess.devicesettings.chargertype.edit) {
        xc.push({
            headerName: "Edit",
            field: "_edit",
            cellRenderer: (p) =>  (+p.data._id) === 1 ? "" : `<img  src="${url}/assets/img/icons/edit.svg"/>`,
            width: 50
        });
    }
    if (useraccess.devicesettings.chargertype.delete) {
        xc.push({
            headerName: "Delete",
            field: "_delete",
            cellRenderer: (p) =>   (+p.data._id) === 1 ? "" : `<img  src="${url}/assets/img/icons/delete-2.svg"/>`,
            width: 50
        });
    }
    xc.push({
        headerName: 'Charger Type',
        field: 'chargerType',
        filter: 'agMultiColumnFilter',
        sortingOrder: ['asc', 'desc'],
        sort : 0,
        width: 450,
    })
    return xc;
}