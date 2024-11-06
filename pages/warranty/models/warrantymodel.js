export const newWarranty = () => {
    const model = {
        _id: "",
        warranty : ""
    };
    return model;
}

export const warranyGrid = () => {
    
    let xc = [];
    const haveAccesswarrantyedit = useraccess?.devicesettings?.warranty?.edit ?? false;
    if (haveAccesswarrantyedit) {
        xc.push({
            headerName: "Edit",
            field: "_edit",
            cellRenderer: (p) => `<img  src="${url}/assets/img/icons/edit.svg"/>`,
            width: 50
        });
    }
    const haveAccesswarrantydelete = useraccess?.devicesettings?.warranty?.delete ?? false;
    if (haveAccesswarrantydelete) {
        xc.push({
            headerName: "Delete",
            field: "_delete",
            cellRenderer: (p) => `<img  src="${url}/assets/img/icons/delete-2.svg"/>`,
            width: 50
        });
    }
    xc.push({
        headerName: 'Description',
        field: 'warranty',
        filter: 'agMultiColumnFilter',
        sortingOrder: ['asc', 'desc'],
        sort : 0,
        width: 450,
    })
    return xc;
}

