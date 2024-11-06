export const netKitModel = () => {
    const model = {
        _id: "",
        kitCode: "",
        kitType : ""
    }

    return model;
}

export const kitGrid = () => {
    let xc = [];
    const haveAccessKitstatusEdit = useraccess?.devicesettings?.kitstatus?.edit ?? false;
    if (haveAccessKitstatusEdit) {
        xc.push({
            headerName: "Edit",
            field: "_edit",
            cellRenderer: (p) => `<img  src="${url}/assets/img/icons/edit.svg"/>`,
            width: 50
        });
    }
    const haveAccessKitstatusDelete = useraccess?.devicesettings?.kitstatus?.delete ?? false;
    if (haveAccessKitstatusDelete) {
        xc.push({
            headerName: "Delete",
            field: "_delete",
            cellRenderer: (p) => `<img  src="${url}/assets/img/icons/delete-2.svg"/>`,
            width: 50
        });
    }
    xc.push({
        headerName: 'Code',
        field: 'kitCode',
        filter: 'agMultiColumnFilter',
        sortingOrder: ['asc', 'desc'],
        width: 110,
    })
    xc.push({
        headerName: 'Description',
        field: 'kitType',
        filter: 'agMultiColumnFilter',
        sortingOrder: ['asc', 'desc'],
        width: 350,
    })
    

    return xc;
}