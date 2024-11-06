export const newConditionModel = () => {
    const model = {
        _id: "",
        productCondition : ""
    }
    return model;
}

export const conditionGrid = () => {
    const xc = [];
    if (useraccess?.devicesettings?.conditions?.edit ?? false) {
        xc.push({
            headerName: "Edit",
            field: "_edit",
            cellRenderer: (p) => `<img  src="${url}/assets/img/icons/edit.svg"/>`,
            width: 50
        });
    }
    if (useraccess?.devicesettings?.conditions?.delete ?? false) {
        xc.push({
            headerName: "Delete",
            field: "_delete",
            cellRenderer: (p) => `<img  src="${url}/assets/img/icons/delete-2.svg"/>`,
            width: 50
        });
    }
    xc.push({
        headerName: 'Condition',
        field: 'productCondition',
        filter: 'agMultiColumnFilter',
        sortingOrder: ['asc', 'desc'],
        width: 450,
    })
    return xc;

}