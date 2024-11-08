export const newShopModel = () => {
    const model = {
        _id: "",
        shopCode: "",
        shopName: "",
        shopLocation: "",
        shopCurrencyType : ""
    }
    return model;
}

export const shopModelGrid = () => {
    let xc = [];
    
    if (useraccess.shops.edit) {
        xc.push({
            headerName: "Edit",
            field: "_edit",
            cellRenderer: (p) => `<img  src="${url}/assets/img/icons/edit.svg"/>`,
            width: 50
        });
    }
    if (useraccess.shops.delete) {
        xc.push({
            headerName: "Delete",
            field: "_delete",
            cellRenderer: (p) => `<img  src="${url}/assets/img/icons/delete-2.svg"/>`,
            width: 50
        });
    }
    xc.push({
        headerName: 'Code#',
        field: 'shopCode',
        filter: 'agMultiColumnFilter',
        sortingOrder: ['asc', 'desc'],
        width: 140,
    })
    xc.push({
        headerName: 'Name',
        field: 'shopName',
        filter: 'agMultiColumnFilter',
        sortingOrder: ['asc', 'desc'],
        width: 140,
    })
    xc.push({
        headerName: 'Location',
        field: 'shopLocation',
        filter: 'agMultiColumnFilter',
        sortingOrder: ['asc', 'desc'],
        width: 140,
    })
    xc.push({
        headerName: 'Currency Type',
        field: 'shopCurrencyType',
        cellRenderer : p => p.data.shopCurrencyType.toUpperCase(),
        filter: 'agMultiColumnFilter',
        sortingOrder: ['asc', 'desc'],
        width: 140,
    })
    if (useraccess.shops.priceaccess) {
        xc.push({
            headerName: 'Avialable Devices',
            field: 'totdevices',
            
            filter: 'agMultiColumnFilter',
            sortingOrder: ['asc', 'desc'],
            width: 140,
        })
        xc.push({
            headerName: 'Total Value',
            field: 'totamount',
            filter: 'agMultiColumnFilter',
            sortingOrder: ['asc', 'desc'],
            width: 140,
        })

    }
    return xc;
}